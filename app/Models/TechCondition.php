<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property-read Proposition proposition
 * @property-read string file
 * @property-read string qrcode
 */
class TechCondition extends Model {
    use HasFactory;

    protected $fillable = ['proposition_id', 'qrcode', 'status', 'qrcode', 'file'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }
}
