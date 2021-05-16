<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposition extends Model {
    use HasFactory;

    protected $fillable = ['number', 'district', 'activity_type', 'applicant', 'build_type', 'status', 'type', 'file', 'delete_at'];
}
