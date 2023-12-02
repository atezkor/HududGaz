<?php

namespace App\Services\Mounter;

use App\Models\Mounter;
use App\Services\CrudService;
use App\Utilities\StorageManager;


class MounterService extends CrudService {
    use StorageManager;

    public function __construct() {
        $this->model = new Mounter();
    }

    public function create($data) {
        $data['license'] = $this->createFile('storage/mounters', $data['license']);
        $this->model->fill($data);
        $this->model->save();
    }

    public function update($data, $model) {
        if (isset($data['license'])) {
            $data['license'] = $this->createFile('storage/mounters', $data['license']);
            $this->deleteFile("storage/mounters", $model->license);
        }

        $model->fill($data);
        $model->save();
    }

    public function delete($model) {
        $this->deleteFile("storage/mounters", $model->license);
        $model->delete();
    }
}
