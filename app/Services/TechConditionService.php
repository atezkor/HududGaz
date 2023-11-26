<?php

namespace App\Services;

use App\Utilities\CodeGenerator;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Generator;
use App\Models\CancelledProposition;
use App\Models\IndividualApplication;
use App\Models\LegalApplication;
use App\Models\Organization;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Models\TechCondition;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;


class TechConditionService extends CrudService {
    use FileUploadManager, StorageManager, CodeGenerator;

    private PDF $pdf;
    private Generator $qrcode;
    private string $path = 'storage/tech_conditions/';
    private string $folder;

    public function __construct(TechCondition $model, PDF $pdf, Generator $qrcode) {
        $this->folder = 'tech_conditions';
        $this->model = $model;
        $this->pdf = $pdf;
        $this->qrcode = $qrcode;
    }

    public function create($data, Recommendation $model = null) {
        $proposition = $model->proposition;
        if (TechCondition::query()->where('proposition_id', $proposition->id)->first())
            return;

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
            'condition' => $tech_condition->id,
            'proposition' => $proposition,
            'filename' => $filename,
            'text' => $data['data'],
            'qrcode' => $this->qrcode->generate($tech_condition->qrcode)
        ]);
    }

    /**
     * This function to showing the tech-condition
     */
    public function get(TechCondition $condition): string {
        return Storage::url('tech_conditions/' . $condition->file);
    }

    public function update(array $data, $model) {
        $filename = time() . '.pdf';
        $this->deleteFile($this->path, $model->file);

        $proposition = $model->proposition;
        $this->createPDF($proposition->recommendation, [
            'condition' => $proposition->tech_condition->id,
            'proposition' => $proposition,
            'filename' => $filename,
            'text' => $data['data'],
            'qrcode' => $this->qrcode->generate($model->qrcode)
        ]);
        parent::update(['file' => $filename], $model);
    }

    /**
     * Check that such stir has existed before.
     */
    public function checkTin(int $type, int $stir): array {
        if ($type == 1)
            return IndividualApplication::query()->where('stir', $stir)
                ->pluck('stir', 'proposition_id')->toArray();

        if ($type == 2)
            return LegalApplication::query()->where('legal_stir', $stir)
                ->pluck('legal_stir', 'proposition_id')->toArray();

        return LegalApplication::query()->where('leader_stir', $stir)
            ->pluck('leader_stir', 'proposition_id')->toArray();
    }

    public function upload($request, TechCondition $condition) {
        $proposition = $condition->proposition;
        $recommendation = $proposition->recommendation;
        $this->deleteFile($this->path, $condition->file);
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

    private function createPDF(Recommendation $recommendation, array $addition) {
        $organ = $recommendation->org;
        $data = [
            'id' => $addition['condition'],
            'recommendation' => $recommendation,
            'proposition' => $addition['proposition'],
            'organ' => $organ,
            'organization' => Organization::Data()
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
        return $this->storeFile($file, $this->folder);
    }
}
