<?php

namespace App\Services;

use App\Models\District;
use App\Models\License;
use App\Models\Montage;
use App\Models\Organization;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\UploadedFile;


class LicenseService extends CrudService {
    use FileUploadManager, StorageManager;

    private PDF $pdf;

    private string $path = "storage/permits/";
    private string $folder;

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
            'district' => $proposition->organ->district->name,
        ]);
        $license->save();

        /* Create permit */
        $this->createPDF($license);
    }

    private function createPDF(License $license) {
        $districts = District::query()->pluck('name', 'id');

        $filename = time() . '.pdf';
        $proposition = $license->proposition;
        $recommendation = $proposition->recommendation;
        $district = $districts[$license->district];

        $data = [
            'permit' => $license,
            'proposition' => $proposition,
            'recommendation' => $recommendation,
            'organization' => Organization::Data(),
            'designer' => $license->project->designer->name,
            'installer' => $license->montage->mounter->short_name,
            'district' => $district,
            'meters' => [], // $recommendation->GasMeters(), // TODO
            'equipments' => [] // $recommendation->getEquipments() // TODO
        ];

        view()->share($data);
        $this->pdf->loadView('engineer.permit')->save($this->path . $filename);
        $license->update(['pdf' => $filename]);
    }

    public function upload(UploadedFile $file, License $permit) {
        $this->deleteFile('storage/permits/', $permit->pdf);
        $filename = $this->store($file, 'permits');

        $permit->update(['pdf' => $filename, 'status' => License::PRESENTED]);
        $permit->proposition->update(['status' => 20]);
    }
}
