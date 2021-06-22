<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property int region
 */
class Region extends BaseModel {

    protected $fillable = ['org_number', 'lead_engineer', 'section_leader', 'region', 'org_name', 'address', 'address_krill',
        'email', 'phone', 'fax'];

    public function getDistrictAttribute() {
        return districts()[$this->getAttribute('region')];
    }
}
