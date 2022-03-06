<?php

namespace App\Services;

use App\Models\Montage;
use App\Models\License;
use App\Models\Organization;
use Barryvdh\DomPDF\PDF;


class LicenseService extends CrudService {

    private PDF $pdf;
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
        $this->pdf->loadView('engineer.permit')->save('storage/permits/' . $filename);
        $license->update(['file' => $filename]);
    }
}
