<?php

namespace App\Models;


class IndividualApplicant extends Application {

    public $timestamps = false;

    protected $table = "physical_applications";

    protected $fillable = ['proposition_id', 'name', 'surname', 'phone', 'passport', 'tin', 'pin_fl'];

    public function getNameAttribute(): string {
        return $this->getAttribute('name');
    }

    public function getPersonNameAttribute() {
        return $this->getAttribute('name');
    }
}
