<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Equipment extends Model {

    protected $table = 'equipments'; // Bu jadval nomi equipment emas, equipments bo'lishi uchun kerak

    protected $fillable = ['equipment_type_id', 'name'];
}
