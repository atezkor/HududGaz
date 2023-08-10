<?php

namespace App\Services;

use App\Models\Designer;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;


class DesignerService extends CrudService {
    use StorageManager, FileUploadManager;

    public function __construct(Designer $designer) {
        $this->model = $designer;
        $this->folder = 'designers';
    }

    public function create($data) {
        $data['document'] = $this->uploadFile('storage/designers', $data['document']);
        $this->model->fill($data);
        $this->model->save();
    }

    public function update($data, $model) {
        if (isset($data['document'])) {
            $data['document'] = $this->uploadFile('storage/designers', $data['document']);
            $this->deleteFile($this->folder, $model->document);
        }

        $model->fill($data);
        $model->save();
    }

    public function delete($model) {
        $this->deleteFile($this->folder, $model->document);
        $model->delete();
    }
}
