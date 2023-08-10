<?php

namespace App\Utilities;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


trait StorageManager {

    function fileUrl($path, $file): string {
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
}
