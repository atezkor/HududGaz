<?php

namespace App\Models;

/**
 * @property int region
 */
class Region extends \Illuminate\Database\Eloquent\Model {

    protected $fillable = ['org_number', 'lead_engineer', 'section_leader', 'region', 'org_name', 'address', 'address_krill',
        'email', 'phone', 'fax'];
}
