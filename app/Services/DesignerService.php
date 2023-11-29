<?php

namespace App\Services;

use App\Exceptions\DesignerHasProjectException;
use App\Models\Designer;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;


class DesignerService extends CrudService {
    use StorageManager, FileUploadManager;

    private string $path = 'storage/designers';
    private string $folder;

    public function __construct(Designer $designer) {
        $this->model = $designer;
        $this->folder = 'designers';
    }

    public function create($data) {
        $data['license'] = $this->uploadFile('storage/designers', $data['license']);
        $this->model->fill($data);
        $this->model->save();
    }

    /**
     * @param array $data
     * @param Designer $model
     */
    public function update(array $data, $model) {
        if (isset($data['license'])) {
            $data['license'] = $this->uploadFile($this->path, $data['license']);
            $this->deleteFile($this->folder, $model->license);
        }

        $model->fill($data);
        $model->save();
    }

    /**
     * @param Designer $model
     * @throws DesignerHasProjectException
     */
    public function delete($model) {
        if ($model->projects->count()) {
            throw new DesignerHasProjectException();
        }

        $this->deleteFile($this->folder, $model->license);
        $model->delete();
    }
}
