<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property HasOne individual
 * @property HasOne legal
 * @property int type
 * @property $applicant
 * @property int status
 * @property int id
 * @property int organ
 * @property-read Recommendation recommendation
 * @property-read string file
 * @property-read int build_type
 */
class Proposition extends Model {

    use HasFactory;

    protected $fillable = ['number', 'organ', 'activity_type', 'applicant', 'build_type', 'status', 'type', 'file', 'delete_at'];

    public function individual(): HasOne {
        return $this->hasOne(Individual::class);
    }

    public function legal(): HasOne {
        return $this->hasOne(Legal::class);
    }

    public function applicant(): HasOne {
        return $this->type == 1 ? $this->individual() : $this->legal();
    }

    public function percent($term = 72): string {
        $now = time() - date_timestamp_get(date_create($this->getAttribute('created_at')));
        $percent = 100 - $now / (3600 * $term) * 100;
        return number_format($percent, 0, '.', '');
    }

    public function limit($limit, int $offset = 0) {
        return $limit[$this->status - $offset];
    }

    public function recommendation(): HasOne {
        return $this->hasOne(Recommendation::class);
    }

    public function tech_condition(): HasOne {
        return $this->hasOne(TechCondition::class);
    }
}
