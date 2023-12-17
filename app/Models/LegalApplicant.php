<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LegalApplicant extends Model {

    public $timestamps = false;

    protected $fillable = [
        'proposition_id', 'tin', 'name', 'email', 'phone',
        'director', 'director_pin_fl'
    ];

    public function getNameAttribute(): string {
        return $this->getAttribute('name');
    }

    public function getPersonNameAttribute() {
        return $this->getAttribute('director');
    }
}
