<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model {
    use HasFactory;

    protected $fillable = ['address', 'access_point', 'above_len', 'under_len', 'diameter', 'depth', 'capability',
        'real_capacity', 'pressure_win', 'pressure_sum', 'grc', 'consumption', 'description', 'additional'];
}
