<?php

namespace App\Services;

use App\Models\Equipment;


class EquipmentService extends CrudService {

    public function __construct() {
        $this->model = new Equipment();
    }
}
