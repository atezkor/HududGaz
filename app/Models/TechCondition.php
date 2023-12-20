<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property-read Proposition proposition
 * @property-read int id
 * @property-read Project project
 * @property-read string file
 * @property-read string qrcode
 */
class TechCondition extends Application {

    protected $fillable = ['proposition_id', 'qrcode', 'status', 'file'];

    public const CREATED = 1;

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function project(): HasOne {
        return $this->hasOne(Project::class);
    }

    public function montage(): HasOne {
        return $this->hasOne(Montage::class);
    }
}
