<?php

namespace App\Services;

use App\Models\Designer;
use Illuminate\Support\Facades\File;


class DesignerService extends CrudService {

    public function __construct() {
        $this->model = new Designer();
    }

    public function create($data) {
        $data['document'] = $this->fileCreate($data['document']);
        $this->model->fill($data);
        $this->model->save();
    }

    public function update($data, $model) {
        if (isset($data['document'])) {
            $data['document'] = $this->fileCreate($data['document']);
            $this->fileDelete($model->document);
        }

        $model->fill($data);
        $model->save();
    }

    public function delete($model) {
        $this->fileDelete($model->document);
        $model->delete();
    }

    private function fileCreate($file): string {
        $name = time() . '.' . $file->extension();
        $file->move('storage/designers', $name);
        return $name;
    }

    private function fileDelete($path) {
        File::delete('storage/designers/' . $path);
    }
}
