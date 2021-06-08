<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\TechCondition;
use Illuminate\View\View;


class TechConditionService extends CrudService {
    public function __construct(TechCondition $model) {
        $this->model = $model;
    }

    public function store($text, $model): View {
        $equipments = json_decode($model->getAttribute('equipments'));
        foreach ($equipments as $equipment) {
            $equipment->equipment = $model->equipment($equipment->equipment);
            $equipment->type = $model->equipType($equipment->type);
        }

        return view("technic.pdf.$model->type", [
            'data' => $text,
            'recommendation' => $model,
            'proposition' => $model->proposition,
            'equipments' => $equipments,
            'organization' => Organization::Data()
        ]);
    }
}
