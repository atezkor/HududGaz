<?php

namespace App\Utilities;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


trait StorageManager {

    function retrieve($path, $file): string {
        return Storage::url($path . $file);
    }

    function createFile($path, $file): string {
        $name = time() . '.' . $file->extension();
        $file->move($path, $name);
        return $name;
    }

    function deleteFile($path, $file) {
        File::delete($path . $file);
    }

    private function move(string $path, string $file, string $suffix) {
        try {
            Storage::move("public/$path" . $file, "public/cancelled/$suffix" . $file);
        } catch (Exception) {
        }
    }
}
