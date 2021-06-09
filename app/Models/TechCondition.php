<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechCondition extends Model {
    use HasFactory;

    protected $fillable = ['proposition_id', 'qrcode', 'organ', 'file'];
}
