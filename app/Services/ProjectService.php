<?php

namespace App\Services;

use App\Models\Project;


class ProjectService extends CrudService {
    public function __construct(Project $model) {
        $this->model = $model;
    }

    public function read($request) {

    }
}
