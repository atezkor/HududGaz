<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class Service extends CrudService {
    public function __construct(Model $model) {
        $this->model = $model;
    }
}
