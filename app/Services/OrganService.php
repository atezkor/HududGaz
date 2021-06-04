<?php

namespace App\Services;

use App\Models\Region;


class OrganService extends CrudService {

    public function __construct(Region $region) {
        $this->model = $region;
    }
}
