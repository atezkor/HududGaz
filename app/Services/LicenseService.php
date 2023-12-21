<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF;
use App\Models\License;
use App\Models\Montage;
use App\Models\Organization;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;


class LicenseService extends CrudService {
    use FileUploadManager, StorageManager;

    private PDF $pdf;
    private string $path = "storage/permits/";

    public function __construct(PDF $pdf) {
        $this->folder = 'montages';
        $this->pdf = $pdf;
    }

    public function createLicense(Montage $montage) {
        $proposition = $montage->proposition;
        $license = new License([
            'proposition_id' => $proposition->id,
            'applicant' => $proposition->applicant->name,
            'project_id' => $montage->project->id,
            'montage_id' => $montage->id,
            'district' => $proposition->organization->district,
        ]);
        $license->save();

        /* Create permit */
        $this->createPDF($license);
    }

    private function createPDF(License $license) {
        $filename = time() . '.pdf';
        $proposition = $license->proposition;
        $recommendation = $proposition->recommendation;
        $district = districts()[$license->district];

        $data = [
            'permit' => $license,
            'proposition' => $proposition,
            'recommendation' => $recommendation,
            'organization' => Organization::Data(),
            'designer' => $license->project->designer->org_name,
            'installer' => $license->montage->mounter->short_name,
            'district' => $district,
            'meters' => $recommendation->GasMeters(),
            'equipments' => $recommendation->getEquipments()
        ];

        view()->share($data);
        $this->pdf->loadView('engineer.permit')->save($this->path . $filename);
        $license->update(['file' => $filename]);
    }

    public function upload($file, License $permit) {
        $this->deleteFile('storage/permits/', $permit->file);
        $filename = $this->store($file, 'permits');

        $permit->update(['file' => $filename, 'status' => 2]);
        $permit->proposition->update(['status' => 20]);
    }
}
