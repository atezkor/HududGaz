<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property int id
 */
class Equipment extends BaseModel {

    protected $table = 'equipments'; // Bu jadval nomi equipment emas, equipments bo'lishi uchun kerak
    protected $fillable = ['name'];

    public function types(): HasMany {
        return $this->hasMany(EquipmentType::class);
    }
}
