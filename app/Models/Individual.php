<?php

namespace App\Models;


class Individual extends Model {
    public $timestamps = false;
    protected $fillable = ['proposition_id', 'organ', 'full_name', 'phone', 'passport', 'stir', 'status'];

    public function getNameAttribute(): string {
        return $this->getAttribute('full_name');
    }

    public function getPersonNameAttribute() {
        return $this->getAttribute('full_name');
    }
}
