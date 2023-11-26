<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int region
 * @property string district
 */
class Organ extends Model {

    protected $fillable = [
        'org_number', 'lead_engineer', 'section_leader', 'district', 'org_name', 'address', 'address_krill',
        'email', 'phone', 'fax'
    ];

    public function getDistrictNameAttribute() {
        return districts()[$this->getAttribute('district')];
    }
}
