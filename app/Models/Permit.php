<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 * @property Project project_relation
 * @property Montage montage_relation
 * @property string district
 * @property string file
 */
class Permit extends BaseModel {
    use HasFactory;
    protected $fillable = ['proposition_id', 'project', 'montage', 'district', 'status', 'file'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function project_relation(): BelongsTo {
        return $this->belongsTo(Project::class, 'project');
    }

    public function montage_relation(): BelongsTo {
        return $this->belongsTo(Montage::class, 'montage');
    }
}
