<?php
namespace App\Services;

use App\Interfaces\ICrudService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
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

    protected function storeFile(UploadedFile $file): string {
        $filename = time() . '.' . $file->extension();
        $file->storeAs("public/$this->folder", $filename);
        return $filename;
    }

    protected function deleteFile(string $file) {
        File::delete("storage/$this->folder/" . $file);
    }
}
