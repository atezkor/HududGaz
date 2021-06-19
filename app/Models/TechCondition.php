<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property-read Proposition proposition
 * @property-read string file
 * @property-read string qrcode
 */
class TechCondition extends Model {

    protected $fillable = ['proposition_id', 'qrcode', 'status', 'qrcode', 'file'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }
}
