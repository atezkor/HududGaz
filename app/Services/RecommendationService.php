<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;


class RecommendationService extends CrudService {
    use FileUploadManager, StorageManager;

    private string $path = 'public/recommendations/';
    private string $folder;

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
        if ($recommendation->pdf) {
        }

        $proposition = $recommendation->proposition;
        $organ = $recommendation->organ;


        $data = [
            'model' => $recommendation,
            'proposition' => $proposition,
            'organ' => $organ,
            'applicant' => $proposition->applicant,
            'district' => $organ->district->name,
            'organization' => Organization::Data()
        ];

        if ($recommendation->type == Recommendation::ACCEPT) {
            $equipments = $recommendation->getEquipments();

            $data['equipments'] = $equipments;
            $data['build_type'] = $proposition->buildType();
            $data['activity'] = $proposition->activity;
        }

        view()->share($data);
        $this->pdf->loadView('organ.pdf.' . $recommendation->type);
        return $this->pdf->stream(time() . '.pdf');
    }

    public function upload(UploadedFile $pdf, Recommendation $recommendation) {
        if ($recommendation->pdf) {
            $this->deleteFile($this->folder, $recommendation->pdf);
        }

        $recommendation->setAttribute('status', Recommendation::PRESENTED);
        $recommendation->setAttribute('pdf', $this->storeFile($pdf, $this->folder));

        $recommendation->update();
        $recommendation->proposition->update(['status' => Proposition::PRESENTED]);
    }

    public function update($data, $model) {
        $data['status'] = Recommendation::CREATED;
        parent::update($data, $model);
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
}
