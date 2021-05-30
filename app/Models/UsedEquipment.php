<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedEquipment extends Model {
    use HasFactory;

    protected $fillable = ['rec_id', 'equipment', 'type', 'number'];
}
