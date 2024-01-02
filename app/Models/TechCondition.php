<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property-read int id
 * @property string $pdf
 * @property-read string qrcode
 * @property-read int $applicant_id
 * @property-read Proposition proposition
 * @property-read Project project
 */
class TechCondition extends Application {

    protected $fillable = ['proposition_id', 'applicant_id', 'qrcode', 'status', 'pdf'];

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
