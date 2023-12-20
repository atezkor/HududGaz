<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read District district
 */
class Organ extends Model {

    protected $fillable = [
        'name', 'tin', 'lead_engineer', 'department_head',
        'district_id', 'address', 'address_cyrill',
        'email', 'phone', 'fax'
    ];

    public function district(): BelongsTo {
        return $this->belongsTo(District::class);
    }
}
