<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 * @property string type
 * @property Region org
 *
 */
class Recommendation extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['proposition_id', 'organ', 'status', 'address', 'access_point', 'gas_network', 'pipeline', 'length', 'diameter', 'depth', 'capability',
        'pressure_win', 'pressure_sum', 'grc', 'consumption', 'equipments', 'additional', 'description', 'type', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function org(): BelongsTo {
        return $this->belongsTo(Region::class, 'organ');
    }

    public function equipment(int $id): string {
        return Equipment::query()->find($id)->getAttribute('name');
    }

    public function equipType(int $id): string {
        return EquipmentType::query()->find($id)->getAttribute('type');
    }
}
