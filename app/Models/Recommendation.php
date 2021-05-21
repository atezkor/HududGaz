<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model {
    use HasFactory;

    protected $fillable = ['proposition_id', 'status', 'address', 'access_point', 'above_len', 'under_len', 'diameter', 'depth', 'capability',
        'real_capacity', 'pressure_win', 'pressure_sum', 'grc', 'consumption', 'description', 'additional', 'file'];

    function proposition(): Proposition|Model {
        return $this->belongsTo(Proposition::class)->first();
    }

    function organ($id): Region|Model {
        return Region::query()->find($id);
    }
}
