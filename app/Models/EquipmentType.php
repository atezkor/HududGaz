<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 */
class EquipmentType extends BaseModel {

    protected $fillable = ['name', 'static'];

    public function equipments(): HasMany {
        return $this->hasMany(Equipment::class);
    }

    public function checkStatic(): bool {
        return $this->getAttribute('static');
    }
}
