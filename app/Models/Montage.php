<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Proposition proposition
 * @property-read Project project
 * @property-read Mounter mounter
 * @property-read int status
 * @property-read string file
 * @property int organ
 * @property int id
 */
class Montage extends Application {

    public const CREATED = 1;
    public const COMPLETED = 5;

    protected $fillable = ['proposition_id', 'tech_condition_id', 'project_id', 'mounter_id', 'applicant', 'status', 'organ', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function mounter(): BelongsTo {
        return $this->belongsTo(Mounter::class);
    }

    public function limit($limit, $distance = 14) {
        return parent::limit($limit, $distance);
    }
}
