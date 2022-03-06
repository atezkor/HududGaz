<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Proposition proposition
 * @property Project project
 * @property Montage montage
 * @property string district
 * @property string file
 */
class License extends BaseModel {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['proposition_id', 'applicant', 'project_id', 'montage_id', 'district', 'status', 'file'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function montage(): BelongsTo {
        return $this->belongsTo(Montage::class);
    }
}
