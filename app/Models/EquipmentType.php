<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class EquipmentType extends BaseModel {

    protected $fillable = ['equipment_id', 'type', 'order'];
}
