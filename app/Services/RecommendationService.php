<?php

namespace App\Services;

use App\Models\Recommendation;
use Illuminate\Http\RedirectResponse;


class RecommendationService extends CrudService {
    private string $path = 'storage/recommendations';

    public function __construct(Recommendation $model) {
        $this->model = $model;
    }

    public function show($proposition): RedirectResponse {
        return redirect($this->path . '/' . $proposition->file);
    }

    public function upload($request) {

    }


//    private function createFile($file): string {
//        $name = time() . '.' . $file->extension();
//        $file->move($this->path, $name);
//        return $name;
//    }
//
//    private function deleteFile($file) {
//        File::delete($this->path . '/' . $file);
//    }
}
