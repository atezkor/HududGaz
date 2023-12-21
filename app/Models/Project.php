<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $organ
 * @property-read int $status
 * @property-read string $pdf
 * @property-read Designer $designer
 * @property-read Proposition $proposition
 * @property-read TechCondition $condition
 */
class Project extends Application {

    public const CREATED = 1;
    public const ACCEPTED = 2;
    public const REVIEWED = 3;
    public const CANCELLED = 4;
    public const COMPLETED = 5;

    protected $fillable = ['proposition_id', 'tech_condition_id', 'designer_id', 'organ', 'status', 'pdf', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function designer(): BelongsTo {
        return $this->belongsTo(Designer::class);
    }

    public function condition(): BelongsTo {
        return $this->belongsTo(TechCondition::class, 'tech_condition_id');
    }

    public function limit($limit, int $distance = 9) {
        return parent::limit($limit, $distance);
    }
}
