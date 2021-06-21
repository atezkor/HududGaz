<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 * @property string type
 * @property Region org
 * @property string file
 *
 */
class Recommendation extends Model {
    public $timestamps = false;

    protected $fillable = ['proposition_id', 'organ', 'status', 'address', 'access_point', 'gas_network', 'pipeline', 'length',
        'pipe1', 'pipe2', 'depth', 'capability', 'pressure_win', 'pressure_sum', 'grc', 'consumption', 'equipments',
        'additional', 'description', 'type', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function org(): BelongsTo {
        return $this->belongsTo(Region::class, 'organ');
    }

    public function getEquipments() {
        $equipments = json_decode($this->getAttribute('equipments'));
        if (!$equipments)
            return [];

        foreach ($equipments as $equipment) {
            $equipment->equipment = $this->equipment($equipment->equipment);
            $equipment->type = $this->equipType($equipment->type);
        }

        return $equipments;
    }

    private function equipment(int $id): string {
        return Equipment::query()->find($id)->getAttribute('name');
    }

    private function equipType(int $id): string {
        return EquipmentType::query()->find($id)->getAttribute('type');
    }
}
