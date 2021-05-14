<?php

namespace App\Services;

use App\Models\Mounter;
use Illuminate\Support\Facades\File;


class MounterService extends CrudService {

    public function __construct() {
        $this->model = new Mounter();
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

    /* Fitters */
    public function worker($data, $model) {
        if (isset($data['document'])) {
            $data['document'] = $this->fileCreate($data['document'], '/workers');
            $this->fileDelete($model->document, 'workers/');
        }

        $model->fill($data);
        $model->save();
    }

    public function deleteWorker($model) {
        $this->fileDelete($model->document, 'workers/');

        $model->delete();
    }

    private function fileCreate($file, $worker = ''): string {
        $name = time() . '.' . $file->extension();
        $file->move('storage/mounters' . $worker, $name);
        return $name;
    }

    private function fileDelete($path, $worker = '') {
        File::delete("storage/mounters/$worker" . $path);
    }
}
