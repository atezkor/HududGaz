<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $pin_fl
 */
class PhysicalApplicant extends Model {

    protected $fillable = ['name', 'surname', 'phone', 'passport', 'tin', 'pin_fl'];

    public function propositions(): HasMany {
        return $this->hasMany(Proposition::class, 'id', 'proposition_id');
    }
}
