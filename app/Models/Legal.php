<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legal extends Model {
    use HasFactory;
    protected $fillable = ['proposition_id', 'legal_stir', 'legal_name', 'email', 'leader', 'leader_stir', 'phone', 'status'];
}
