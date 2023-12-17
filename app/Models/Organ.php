<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read string district
 */
class Organ extends Model {

    protected $fillable = [
        'name', 'tin', 'lead_engineer', 'department_head',
        'district_id', 'address', 'address_cyrill',
        'email', 'phone', 'fax'
    ];
}
