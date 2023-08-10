<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Services\Interfaces\ICrudService;


abstract class CrudService implements ICrudService {
    /**
     * @var Model
     * This variable for detect Model
     */
    protected Model $model;
    protected string $folder;

    /**
     * @param array $data
     */
    public function create($data) {
        $this->model->fill($data);
        $this->model->save();
    }

    public function update(array $data, $model) {
        $model->fill($data);
        $model->save();
    }

    public function delete($model) {
        $model->delete();
    }
}
