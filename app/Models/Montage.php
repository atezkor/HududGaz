<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int organ
 * @property-read string file
 * @property Proposition proposition
 */
class Montage extends Model {
    use HasFactory;
    protected $fillable = ['proposition_id', 'condition', 'project', 'organ', 'status', 'file', 'comment'];

    public function proposition(): BelongsTo {
        return $this->belongsTo(Proposition::class);
    }
}
