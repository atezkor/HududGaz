<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed proposition
 * @property mixed type
 */
class Recommendation extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['proposition_id', 'status', 'address', 'access_point', 'above_len', 'under_len', 'diameter', 'depth', 'capability',
        'real_capacity', 'pressure_win', 'pressure_sum', 'grc', 'consumption', 'description', 'additional', 'type', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    function organ($id): Region|Model {
        return Region::query()->find($id);
    }
}
