<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 */
class Equipment extends Model {
    use HasFactory;

    protected $table = 'equipments'; // Bu jadval nomi equipment emas, equipments bo'lishi uchun kerak
    protected $fillable = ['name'];

    public function types(): HasMany {
        return $this->hasMany(EquipmentType::class);
    }
}
