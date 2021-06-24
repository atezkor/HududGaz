<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 */
class Equipment extends BaseModel {

    protected $table = 'equipments'; // Bu jadval nomi equipment emas, equipments bo'lishi uchun kerak
    protected $fillable = ['name', 'static'];

    public function types(): HasMany {
        return $this->hasMany(EquipmentType::class);
    }

    public function checkStatic(): bool {
        return $this->getAttribute('static');
    }
}
