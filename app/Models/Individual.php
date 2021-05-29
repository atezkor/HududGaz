<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['proposition_id', 'full_name', 'phone', 'passport', 'stir', 'status'];
}
