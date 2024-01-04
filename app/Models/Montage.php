<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int $organ_id
 * @property-read int $status
 * @property-read string $pdf
 * @property-read Proposition proposition
 * @property-read Project project
 * @property-read Mounter mounter
 */
class Montage extends Application {

    public const CREATED = 1;
    public const ACCEPTED = 2;
    public const REVIEWED = 3;
    public const CANCELLED = 4;
    public const COMPLETED = 5;

    protected $fillable = ['proposition_id', 'tech_condition_id', 'project_id', 'mounter_id', 'applicant_id', 'organ_id', 'status', 'pdf', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function mounter(): BelongsTo {
        return $this->belongsTo(Mounter::class);
    }

    public function applicant(): BelongsTo {
        return $this->belongsTo(Applicant::class);
    }

    public function limit($limit, $distance = 14) {
        return parent::limit($limit, $distance);
    }
}
