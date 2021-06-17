<?php

namespace App\Services;

use App\Models\Designer;


class DesignerService extends CrudService {

    public function __construct(Designer $designer) {
        $this->model = $designer;
        $this->folder = 'designers';
    }

    public function create($data) {
        $data['document'] = $this->fileCreate($data['document']);
        $this->model->fill($data);
        $this->model->save();
    }

    public function update($data, $model) {
        if (isset($data['document'])) {
            $data['document'] = $this->fileCreate($data['document']);
            $this->deleteFile($model->document);
        }

        $model->fill($data);
        $model->save();
    }

    public function delete($model) {
        $this->deleteFile($model->document);
        $model->delete();
    }

    private function fileCreate($file): string {
        $name = time() . '.' . $file->extension();
        $file->move('storage/designers', $name);
        return $name;
    }
}
