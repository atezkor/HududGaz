<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 * @property-read int organ
 * @property string file
 */
class Project extends Model {
    use HasFactory;

    protected $fillable = ['proposition_id', 'condition', 'status', 'applicant', 'organ', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }
}
