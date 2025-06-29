<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $type
 * @property string $pdf
 * @property int $applicant_id
 * @property string $description
 * @property Proposition $proposition
 * @property Organ $organ
 * @property Applicant $applicant
 */
class Recommendation extends Application {

    public const CREATED = 1;
    public const PRESENTED = 2;
    public const REVIEWED = 3;
    public const REJECTED = -1;
    public const COMPLETED = 5;

    public const ACCEPT = "accept";
    public const REJECT = "reject";

    protected $fillable = [
        'proposition_id', 'organization_id', 'applicant_id', 'type', 'status', 'pdf',
        'address', 'access_point', 'gas_network', 'pipeline', 'pipe_type',
        'length', 'pipe_one', 'pipe_two', 'depth', 'capability', 'pressure_win', 'pressure_sum',
        'grc', 'consumption', 'additional', 'description', 'comment'
    ];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function organ(): BelongsTo { // Previous name: org
        return $this->belongsTo(Organ::class, 'organization_id');
    }

    public function applicant(): BelongsTo {
        return $this->belongsTo(Applicant::class);
    }

    public function limit($limit, $distance = 2) {
        return parent::limit($limit, $distance); // 2, 3 -> x(3) - now only 2
    }
}
