<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 */
class Project extends Model {
    use HasFactory;

    protected $fillable = ['proposition_id', 'status', 'applicant', 'organ', 'file'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }
}
