<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PhysicalApplicant extends Model {

    public $timestamps = false;

    protected $fillable = ['proposition_id', 'name', 'surname', 'phone', 'passport', 'tin', 'pin_fl'];

    public function getFullNameAttribute() {
        return $this->getAttribute('name');
    }

    public function propositions(): HasMany {
        return $this->hasMany(Proposition::class, 'id', 'proposition_id');
    }
}
