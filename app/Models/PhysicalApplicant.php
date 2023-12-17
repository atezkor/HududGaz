<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PhysicalApplicant extends Model {

    public $timestamps = false;

    protected $fillable = ['proposition_id', 'name', 'surname', 'phone', 'passport', 'tin', 'pin_fl'];

    public function getNameAttribute(): string {
        return $this->getAttribute('name');
    }

    public function getPersonNameAttribute() {
        return $this->getAttribute('name');
    }
}
