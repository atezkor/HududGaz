<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model {
    use HasFactory;

    protected $fillable = ['org_number', 'lead_engineer', 'section_leader', 'region', 'org_name', 'address_latin', 'address', 'email', 'phone', 'fax'];
}
