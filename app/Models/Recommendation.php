<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $type
 * @property string $pdf
 * @property Proposition $proposition
 * @property Organ $organ
 */
class Recommendation extends Application {

    public const CREATED = 1;
    public const PRESENTED = 2;
    public const COMPLETED = 4;
    public const REJECTED = -1;

    public const ACCEPT = "accept";
    public const REJECT = "reject";

    protected $fillable = [
        'proposition_id', 'organization_id', 'type', 'status', 'pdf',
        'address', 'access_point', 'gas_network', 'pipeline', 'pipe_type',
        'length', 'pipe1', 'pipe2', 'depth', 'capability', 'pressure_win', 'pressure_sum',
        'grc', 'consumption', 'equipments',
        'additional', 'description', 'comment'
    ];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function organ(): BelongsTo { // Previous name: org
        return $this->belongsTo(Organ::class, 'organization_id');
    }

    public function getEquipments() {
        $equipments = json_decode($this->getAttribute('equipments'));
        if (!$equipments)
            return [];

        foreach ($equipments as $key => $equipment) {
            $equipment->equipment = $this->equipment($equipment->equipment);
            if (!$equipment->equipment) {
                unset($equipments[$key]);
                continue;
            }
            $equipment->type = $this->equipType($equipment->type);
        }

        return $equipments;
    }

    public function limit($limit, $distance = 2) {
        return parent::limit($limit, $distance); // 2, 3 -> x(3) - now only 2
    }

    public function GasMeters() {
        $equipments = json_decode($this->getAttribute('equipments'));
        if (!$equipments)
            return [];

        foreach ($equipments as $key => $equipment) {
            if ($equipment->equipment != 1) {
                unset($equipments[$key]);
                continue;
            }

            $equipment->equipment = $this->equipment($equipment->equipment, true);
            if (!$equipment->equipment) {
                unset($equipments[$key]);
                continue;
            }
            $equipment->type = $this->equipType($equipment->type);
        }

        return $equipments;
    }

    private function equipment(int $id, $meter = false): string {
        return EquipmentType::query()->where('static', $meter)->find($id)->name ?? '';
    }

    private function equipType(int $id): string {
        return Equipment::query()->find($id)->type ?? '';
    }
}
