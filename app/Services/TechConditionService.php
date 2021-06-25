<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\Proposition;
use App\Models\Organization;
use App\Models\Recommendation;
use App\Models\TechCondition;
use App\Models\CancelledProposition;
use Barryvdh\DomPDF\PDF;
use SimpleSoftwareIO\QrCode\Generator;


class TechConditionService extends CrudService {

    private PDF $pdf;
    private string $path = 'storage/tech_conditions/';
    private Generator $qrcode;

    public function __construct(TechCondition $model, PDF $pdf, Generator $qrcode) {
        $this->folder = 'tech_conditions';
        $this->model = $model;
        $this->pdf = $pdf;
        $this->qrcode = $qrcode;
    }

    public function create($data, Recommendation $model = null) {
        $proposition = $model->proposition;
        $filename = time() . '.pdf';
        $attr = [
            'proposition_id' => $proposition->id,
            'file' => $filename,
            'qrcode' => $this->qrcodeGenerate(4)
        ];

        $tech_condition = new TechCondition($attr);
        $tech_condition->save();
        $proposition->update(['status' => 7]);
        $proposition->applicant->update(['status' => 7]);
        $model->update(['status' => 4, 'description' => $data['description']]);

        $this->createPDF($model, [
            'proposition' => $proposition,
            'filename' => $filename,
            'text' => $data['data'],
            'qrcode' => $this->qrcode->generate($tech_condition->qrcode)
        ]);
    }

    public function show(TechCondition $condition): string {
        return Storage::url('tech_conditions/' . $condition->file);
    }

    public function update(array $data, $model) {
        $filename = time() . '.pdf';
        $this->deleteFile($model->file);

        $proposition = $model->proposition;
        $this->createPDF($proposition->recommendation, [
            'proposition' => $proposition,
            'filename' => $filename,
            'text' => $data['data'],
            'qrcode' => $this->qrcode->generate($model->qrcode)
        ]);
        parent::update(['file' => $filename], $model);
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
        $proposition->update(['status' => 8]); $proposition->applicant->update(['status' => 8]);
    }

    private function createPDF(Recommendation $recommendation, array $addition) {
        $organ = $recommendation->org;
        $data = [
            'recommendation' => $recommendation,
            'proposition' => $addition['proposition'],
            'organ' => $organ,
            'organization' => Organization::Data(),
            'district' => districts()[$organ->getAttribute('region')],
        ];

        if ($recommendation->type == 'accept') {
            $equipments = $recommendation->getEquipments();

            $data['equipments'] = $equipments;
            $data['data'] = $addition['text'];
            $data['qrcode'] = $addition['qrcode'];
        } else {
            $data['reference'] = $addition['text'];
        }

        view()->share($data);
        $this->pdf->loadView("technic.pdf.$recommendation->type");
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

        $this->move('tech_conditions/', $condition->file, 'c');
        $this->move('recommendations/', $recommendation->file, 'r');
        $this->move('propositions/', $proposition->file, 'p');

        $this->delete($condition);
        $this->delete($recommendation);
        $this->delete($proposition);

        $cancelled->save();
    }

    private function uploadFile($file): string {
        return parent::storeFile($file);
    }

    private function move(string $path, string $file, string $suffix) {
        try {
            Storage::move("public/$path" . $file, "public/cancelled/$suffix" . $file);
        } catch (Exception) {}
    }

    private function qrcodeGenerate($length = 10): string {
        $characters = 'abc@defghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $result = '';
        for ($i = 0; $i < $length; $i ++) {
            $result .= $characters[rand(0, $char_length - 1)];
        }

        return $result . time();
    }
}
