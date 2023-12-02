<?php

namespace App\Services\Core;

use Illuminate\Database\Eloquent\Model;


interface ICrudService {

    public function create(array $data);

    public function update($model, array $data);

    public function delete(Model $model);
}
