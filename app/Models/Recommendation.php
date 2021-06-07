<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 * @property string type
 */
class Recommendation extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['proposition_id', 'organ', 'status', 'address', 'access_point', 'gas_network', 'pipeline', 'length', 'diameter', 'depth', 'capability',
        'pressure_win', 'pressure_sum', 'grc', 'consumption', 'equipments', 'additional', 'description', 'type', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    function organ($id): Region|Model {
        return Region::query()->find($id);
    }
}
