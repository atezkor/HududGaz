<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;


class RecommendationService extends CrudService {
    use FileUploadManager, StorageManager;

    private string $path = 'public/recommendations/';
    private PDF $pdf;

    public function __construct(Recommendation $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;
        $this->folder = 'recommendations';
    }

    /**
     * @param array $data
     */
    public function create($data) {
        /* @var Proposition $proposition */
        $proposition = Proposition::query()->find($data['proposition_id']);
        $data['organization_id'] = $proposition->organization_id;
        parent::create($data);
    }

    public function show(Recommendation $recommendation): Response {
        $proposition = $recommendation->proposition;
        $organ = $recommendation->org;

        $data = [
            'model' => $recommendation,
            'proposition' => $proposition,
            'organ' => $organ,
            'consumer' => $proposition->applicant,
            'district' => districts()[$organ->getAttribute('region')],
            'organization' => Organization::Data()
        ];

        if ($recommendation->type == 'accept') {
            $equipments = $recommendation->getEquipments();

            $data['equipments'] = $equipments;
            $data['build_type'] = $proposition->buildType();
            $data['activity'] = $proposition->activity;
        }

        view()->share($data); // TODO

        $this->pdf->loadView('district.pdf.' . $recommendation->type);
        return $this->pdf->stream(time() . '.pdf');
    }

    /**
     * This function allows the person to see the file
     */
    public function techShow(Recommendation $recommendation): string {
        $proposition = $recommendation->proposition;
        if ($proposition->status == 4) {
            $proposition->update(['status' => 5]);
            $proposition->applicant->update(['status' => 5]);
        }

        return $this->fileUrl($this->path, $recommendation->getAttribute('file'));
    }

    public function upload($request, Recommendation $recommendation) {
        if ($recommendation->file)
            $this->deleteFile($this->folder, $recommendation->file);
        $recommendation->setAttribute('status', 2);
        $recommendation->setAttribute('file', $this->storeFile($request->file('file'), $this->folder));
        $recommendation->update();
    }

    /**
     * This function for back recommendation to District
     */
    public function back(Recommendation $recommendation, string $comment) {
        $recommendation->setAttribute('comment', $comment);
        $recommendation->setAttribute('status', 3);
        $recommendation->update();

        $recommendation->proposition->update(['status' => 6]);
        $recommendation->proposition->applicant->update(['status' => 6]);
    }

    public function update($data, $model) {
        $data['status'] = 1;
        parent::update($data, $model);
    }
}
