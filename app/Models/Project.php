<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Proposition proposition
 * @property-read Designer designer
 * @property-read int id
 * @property-read int organ
 * @property-read int status
 * @property-read string file
 */
class Project extends Model {
    protected $fillable = ['proposition_id', 'tech_condition_id', 'designer_id', 'organ', 'status', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class, 'proposition_id');
    }

    public function applicant(): BelongsTo {
        return $this->belongsTo(Proposition::class, 'proposition_id');
    }

    public function designer(): BelongsTo {
        return $this->belongsTo(Designer::class);
    }

    public function limit($limit, int $distance = 9) {
        return parent::limit($limit, $distance);
    }
}
