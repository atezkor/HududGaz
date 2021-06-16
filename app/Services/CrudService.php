<?php
namespace App\Services;

use App\Interfaces\ICrudService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;


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

    protected function deleteFile(string $file) {
        File::delete("storage/$this->folder/" . $file);
    }


//    protected function getModelClass(): Model {
//        if (property_exists($this, 'Model')) {
//            return $this->Model;
//        }
//
//        throw new Exception(get_class($this) . 'Model property not implemented');
//    }
}
