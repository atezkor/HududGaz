<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel {
    use HasFactory;

    public function percent($term = 72): string {
        $now = time() - date_timestamp_get(date_create($this->getAttribute('created_at')));
        $percent = 100 - $now / (3600 * $term) * 100;
        return number_format($percent, 0, '.', '');
    }
}
