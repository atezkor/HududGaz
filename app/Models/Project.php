<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Proposition proposition
 * @property-read Designer designer
 * @property-read int organ
 * @property int status
 * @property string file
 */
class Project extends Model {
    protected $fillable = ['proposition_id', 'applicant', 'condition', 'designer', 'organ', 'status', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function designer(): BelongsTo {
        return $this->belongsTo(Designer::class, 'designer');
    }

    public function time($limit) {
        return $limit[$this->status + 9];
    }
}
