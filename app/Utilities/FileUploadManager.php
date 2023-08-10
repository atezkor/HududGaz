<?php

namespace App\Utilities;

use Illuminate\Http\UploadedFile;

trait FileUploadManager {

    protected function storeFile(UploadedFile $file, $folder): string {
        $filename = time() . '.' . $file->extension();
        $file->storeAs("public/$folder", $filename);
        return $filename;
    }

    private function uploadFile($path, $file): string {
        $name = time() . '.' . $file->extension();
        $file->move($path, $name);
        return $name;
    }
}
