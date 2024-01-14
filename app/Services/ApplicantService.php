<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\LegalApplicant;
use App\Models\PhysicalApplicant;


class ApplicantService extends CrudService {

    public function __construct(Applicant $model) {
        $this->model = $model;
    }

    /**
     * @param array $data
     */
    public function create($data): void {
        /* @var PhysicalApplicant|LegalApplicant $model */

        if (intval($data['type']) === Application::PHYSICAL) {
            $model = PhysicalApplicant::query()->firstOrCreate(
                ['pin_fl' => $data['pin_fl']],
                $data
            );

            $data['physical_applicant_id'] = $model->id;
            $data['tin_pin'] = $model->pin_fl;
        } else {
            $model = LegalApplicant::query()->firstOrCreate([
                'tin' => $data['tin']
            ], $data);

            $data['legal_applicant_id'] = $model->id;
            $data['tin_pin'] = $model->tin;
        }

        $applicant = new Applicant();
        $applicant->fill($data);
        $applicant->save();
    }

    /**
     * @param array $data
     * @param Applicant $model
     */
    public function update(array $data, $model) {
        /* @var PhysicalApplicant|LegalApplicant $applicant */

        if ($data['type'] == Applicant::PHYSICAL) {
            $applicant = PhysicalApplicant::query()->firstOrCreate(
                ['pin_fl' => $data['pin_fl']],
                $data
            );

            $data['physical_applicant_id'] = $applicant->id;
            $data['tin_pin'] = $data['pin_fl'];
        } else {
            $applicant = LegalApplicant::query()->firstOrCreate([
                'tin' => $data['tin']
            ], $data);

            $data['legal_applicant_id'] = $applicant->id;
            $data['tin_pin'] = $data['tin'];
        }

        $model->update($data);
    }
}
