<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model {
    use HasFactory;

    protected $table = 'equipments';
    protected $fillable = ['name'];

    public function types(): HasMany {
        return $this->hasMany(EquipmentType::class);
    }
}
