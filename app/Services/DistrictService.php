<?php

namespace App\Services;

use App\Models\Region;


class DistrictService extends CrudService {

    public function __construct() {
        $this->model = new Region();
    }
}
