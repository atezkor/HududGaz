<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed individual
 * @property mixed legal
 */
class Proposition extends Model {
    use HasFactory;

    protected $fillable = ['number', 'organ', 'activity_type', 'applicant', 'build_type', 'status', 'type', 'file', 'delete_at'];

    function individual(): HasOne {
        return $this->hasOne(Individual::class);
    }

    function legal(): HasOne {
        return $this->hasOne(Legal::class);
    }

    function applicant(): Model {
        return (int) $this->getAttribute('type') === 1 ? $this->individual : $this->legal;
    }

    function percent($term = 72): string {
        $now = time() - date_timestamp_get(date_create($this->getAttribute('created_at')));
        $percent = 100 - $now / (3600 * $term) * 100;
        return number_format($percent, 0, '.', '');
    }
}
