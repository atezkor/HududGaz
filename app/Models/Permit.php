<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Project project
 * @property string district
 */
class Permit extends Model {
    use HasFactory;

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class, 'project');
    }
}
