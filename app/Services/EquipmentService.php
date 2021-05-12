<?php

namespace App\Services;

use App\Models\Equipment;


class EquipmentService extends CrudService {

    public function __construct() {
        $this->model = new Equipment();
    }

    public function typeChange($model, $data) {
        $model->fill($data);
        $model->save();
    }
}
