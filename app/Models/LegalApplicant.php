<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class LegalApplicant extends Model {

    public $timestamps = false;

    protected $fillable = [
        'proposition_id', 'tin', 'name', 'email', 'phone',
        'director', 'director_pin_fl'
    ];

    public function propositions(): HasMany {
        return $this->hasMany(Proposition::class, 'id', 'proposition_id');
    }
}
