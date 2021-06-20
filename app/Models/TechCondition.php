<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property-read Proposition proposition
 * @property-read Project project
 * @property-read string file
 * @property-read string qrcode
 */
class TechCondition extends Model {

    protected $fillable = ['proposition_id', 'qrcode', 'status', 'qrcode', 'file'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function project(): HasOne {
        return $this->hasOne(Project::class, 'condition');
    }
}
