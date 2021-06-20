<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Proposition proposition
 * @property-read Project project_relation
 * @property-read Mounter mounter
 * @property-read int status
 * @property-read string file
 * @property int organ
 * @property int id
 */
class Montage extends Model {
    protected $fillable = ['proposition_id', 'condition', 'project', 'applicant', 'firm', 'status', 'organ', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function project_relation(): BelongsTo {
        return $this->belongsTo(Project::class, 'project');
    }

    public function mounter(): BelongsTo {
        return $this->belongsTo(Mounter::class, 'firm');
    }

    public function time($limit) {
        return $limit[$this->status + 14];
    }
}
