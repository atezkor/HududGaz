<?php

namespace App\Services;

use App\Models\Mounter;
use App\Utilities\StorageManager;


class MounterService extends CrudService {

    use StorageManager;

    public function __construct() {
        $this->model = new Mounter();
    }

    public function create($data) {
        $data['document'] = $this->createFile('storage/mounters', $data['document']);
        $this->model->fill($data);
        $this->model->save();
    }

    public function update($data, $model) {
        if (isset($data['document'])) {
            $data['document'] = $this->createFile('storage/mounters', $data['document']);
            $this->deleteFile("storage/mounters", $model->document);
        }

        $model->fill($data);
        $model->save();
    }

    public function delete($model) {
        $this->deleteFile("storage/mounters", $model->document);
        $model->delete();
    }

    /* Fitters */
    public function worker($data, $model) {
        if (isset($data['document'])) {
            $data['document'] = $this->createFile('storage/mounters/workers', $data['document']);
            $this->deleteFile("storage/mounters/workers", $model->document);
        }

        $model->fill($data);
        $model->save();
    }

    public function deleteWorker($model) {
        $this->deleteFile("storage/mounters/workers", $model->document);
        $model->delete();
    }
}
