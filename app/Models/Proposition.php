<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposition extends Model {
    use HasFactory;

    protected $fillable = ['number', 'organ', 'activity_type', 'applicant', 'build_type', 'status', 'type', 'file', 'delete_at'];

    function individual(): Individual|Model {
        return $this->hasOne(Individual::class)->first();
    }

    function legal(): Legal|Model {
        return $this->hasOne(Legal::class)->first();
    }

    function applicant(): Model {
        return (int) $this->getAttribute('type') === 1 ? $this->individual() : $this->legal();
    }

    function consumer($type = 1): Model {
        return $type == 1 ? $this->individual() : $this->legal();
    }

    function percent($term = 72): string {
        $now = time() - date_timestamp_get(date_create($this->getAttribute('updated_at')));
        $percent = 100 - $now / (3600 * $term) * 100;
        return number_format($percent, 0, '.', '');
    }
}
