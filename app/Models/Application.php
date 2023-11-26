<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Application extends Model {
    use HasFactory;

    public function percent($term = 72): string {
        $now = time() - date_timestamp_get(date_create($this->getAttribute('created_at')));
        $percent = 100 - $now / (3600 * $term) * 100;
        return number_format($percent, 0, '.', '');
    }

    public function progressColor($percent): string {
        if ($percent > 75)
            return 'progress-bar bg-success';
        if ($percent > 25)
            return 'progress-bar bg-warning';
        if ($percent > 0)
            return 'progress-bar bg-danger';
        return 'progress-bar bg-transparent';
    }

    public function limit($limit, int $distance = 0) {
        return $limit[$this->getAttribute('status') + $distance];
    }
}
