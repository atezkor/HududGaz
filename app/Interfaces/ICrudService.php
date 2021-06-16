<?php

namespace App\Interfaces;

interface ICrudService {

    public function create($data);

    public function update(array $data, $model);

    public function delete($model);
}
