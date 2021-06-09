<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\Recommendation;
use App\Models\TechCondition;
use Barryvdh\DomPDF\PDF;


class TechConditionService extends CrudService {

    private PDF $pdf;
    private string $path = '/public/tech_conditions/';

    public function __construct(TechCondition $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;
    }

    public function store($text, Recommendation $model) {
        $organ = $model->org;
        $proposition = $model->proposition;
        $data = [
            'recommendation' => $model,
            'proposition' => $proposition,
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
            $data['data'] = $text;
        } else {
            $data['reference'] = $text;
        }

        $filename = time() . '.pdf';
        $attr = [
            'proposition_id' => $proposition->id,
            'qrcode' => 'AB8674541',
            'file' => $filename
        ];

        $tech_condition = new TechCondition($attr);
        $tech_condition->save();
        $proposition->update(['status' => 7]);
        $proposition->applicant->update(['status' => 7]);
        $model->update(['status' => 4]);

        view()->share($data);
        $this->pdf->loadView("technic.pdf.$model->type");
        $this->pdf->save($this->path . $filename);
    }
}
