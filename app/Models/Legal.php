<?php

namespace App\Models;


class Legal extends Model {
    public $timestamps = false;
    protected $fillable = ['proposition_id', 'organ', 'legal_stir', 'legal_name', 'email', 'leader', 'leader_stir', 'phone', 'status'];

    public function getNameAttribute(): string {
        return $this->getAttribute('legal_name');
    }

    public function getPersonNameAttribute() {
        return $this->getAttribute('leader');
    }
}
