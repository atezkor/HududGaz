<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Proposition proposition
 * @property-read Designer firm
 * @property-read int id
 * @property-read int organ
 * @property-read int status
 * @property-read string file
 */
class Project extends Model {
    protected $fillable = ['proposition_id', 'applicant', 'condition', 'designer', 'organ', 'status', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function firm(): BelongsTo {
        return $this->belongsTo(Designer::class, 'designer');
    }

    public function limit($limit, int $distance = 9) {
        return parent::limit($limit, $distance);
    }
}
