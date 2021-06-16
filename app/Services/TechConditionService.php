<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Proposition;
use App\Models\Organization;
use App\Models\Recommendation;
use App\Models\TechCondition;
use App\Models\CancelledProposition;
use Barryvdh\DomPDF\PDF;


class TechConditionService extends CrudService {

    private PDF $pdf;
    private string $path = 'storage/tech_conditions/';

    public function __construct(TechCondition $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;
        $this->folder = 'tech_conditions';
    }

    public function create($data, Recommendation $model = null) {
        $proposition = $model->proposition;
        $filename = time() . '.pdf';
        $attr = [
            'proposition_id' => $proposition->id,
            'file' => $filename
        ];

        $tech_condition = new TechCondition($attr);
        $tech_condition->save();
        $proposition->update(['status' => 7]);
        $proposition->applicant->update(['status' => 7]);
        $model->update(['status' => 4, 'description' => $data['description']]);

        $this->createPDF($model, [
            'proposition' => $proposition,
            'filename' => $filename,
            'text' => $data['data']
        ]);
    }

    public function show(TechCondition $condition): string {
        return Storage::url('tech_conditions/' . $condition->file);
    }

    public function upload($request, TechCondition $condition) {
        $proposition = $condition->proposition;
        $recommendation = $proposition->recommendation;
        $this->deleteFile($condition->file);
        $condition->fill([
            'file' => $this->uploadFile($request->file('file')),
            'status' => 2
        ]);

        if ($recommendation->type == 'fail') {
            $this->cancel($proposition, $recommendation, $condition);
            return;
        }

        $condition->update();
        $proposition->update(['status' => 8]);
        $proposition->applicant->update(['status' => 8]);
    }

    private function createPDF(Recommendation $model, array $addition) {
        File::makeDirectory($this->path, 0777, true, true);
        $organ = $model->org;
        $data = [
            'recommendation' => $model,
            'proposition' => $addition['proposition'],
            'organ' => $organ,
            'organization' => Organization::Data(),
            'district' => districts()[$organ->getAttribute('region')],
        ];

        if ($model->type == 'accept') {
            $equipments = json_decode($model->getAttribute('equipments'));
            foreach ($equipments as $equipment) {
                $equipment->equipment = $model->equipment($equipment->equipment);
                $equipment->type = $model->equipType($equipment->type);
            }

            $data['equipments'] = $equipments;
            $data['data'] = $addition['text'];
        } else {
            $data['reference'] = $addition['text'];
        }

        view()->share($data);
        $this->pdf->loadView("technic.pdf.$model->type");
        $this->pdf->save($this->path . $addition['filename']);
    }

    private function cancel(Proposition $proposition, Recommendation $recommendation, TechCondition $condition) {
        $cancelled = new CancelledProposition();
        $applicant = $proposition->applicant;
        $cancelled->fill([
            'prop_num' => $proposition->getAttribute('number'),
            'applicant' => $applicant->name,
            'proposition' => 'p' . $proposition->file,
            'recommendation' => 'r' . $recommendation->file,
            'condition' => 'c' . $condition->file,
            'reason' => $recommendation->getAttribute('description')
        ]);


        $this->delete($condition);
        $this->move('tech_conditions/', $condition->file, 'c');

        $this->delete($recommendation);
        $this->move('recommendations/', $recommendation->file, 'r');

        $this->delete($proposition);
        $this->move('propositions/', $proposition->file, 'p');

        $cancelled->save();
    }

    private function uploadFile($file): string {
        $filename = time() . '.pdf';
        $file->storeAs('public/tech_conditions', $filename);
        return $filename;
    }

    private function move(string $path, string $file, string $suffix) {
        Storage::move("public/$path" . $file, "public/cancelled/$suffix" . $file);
    }
}
