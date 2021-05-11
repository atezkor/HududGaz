<?php
namespace App\Services;

use App\Interfaces\ICrudService;
use Illuminate\Database\Eloquent\Model;


abstract class CrudService implements ICrudService {

    /**
     * @var Model
     * This variable for detect Model
     */
    protected Model $model;

    /**
     * @param $data
     */
    public function create($data) {
        $this->model->fill($data);
        $this->model->save();
    }

    public function update($data, $model) {
        $model->fill($data);
        $model->save();
    }

    public function delete($model) {
        $model->delete();
    }


//    protected function getModelClass(): Model {
//        if (property_exists($this, 'Model')) {
//            return $this->Model;
//        }
//
//        throw new Exception(get_class($this) . 'Model property not implemented');
//    }
}
