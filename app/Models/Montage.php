<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int organ
 * @property-read string file
 * @property Proposition proposition
 * @property-read int status
 */
class Montage extends Model {
    protected $fillable = ['proposition_id', 'condition', 'project', 'applicant', 'firm', 'status', 'organ', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function time($limit) {
        return $limit[$this->status + 14];
    }
}
