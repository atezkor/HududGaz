<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 * @property-read int organ
 * @property string file
 * @property int status
 */
class Project extends Model {
    protected $fillable = ['proposition_id', 'applicant', 'condition', 'designer', 'organ', 'status', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function time($limit) {
        return $limit[$this->status + 9];
    }
}
