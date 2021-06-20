<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property HasOne individual
 * @property HasOne legal
 * @property $applicant
 * @property-read Recommendation recommendation
 * @property-read TechCondition tech_condition
 * @property int type
 * @property int status
 * @property int id
 * @property int organ
 * @property-read string file
 * @property-read int build_type
 */
class Proposition extends Model {

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

    public function recommendation(): HasOne {
        return $this->hasOne(Recommendation::class);
    }

    public function tech_condition(): HasOne {
        return $this->hasOne(TechCondition::class);
    }

    public function limit($limit, int $offset = 0) {
        return $limit[$this->status - $offset];
    }
}
