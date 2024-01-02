<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string proposition
 * @property string recommendation
 * @property string condition
 */
class CancelledProposition extends Application {

    protected $fillable = [
        'number', 'applicant_id', 'organization_id', 'proposition', 'recommendation', 'condition', 'reason'
    ];

    public function applicant(): BelongsTo {
        return $this->belongsTo(Applicant::class);
    }
}
