<?php

namespace App\Models;


class IndividualApplication extends Application {

    public $timestamps = false;

    protected $table = "physical_applications";

    protected $fillable = ['proposition_id', 'organ', 'full_name', 'phone', 'passport', 'stir', 'status'];

    public function getNameAttribute(): string {
        return $this->getAttribute('full_name');
    }

    public function getPersonNameAttribute() {
        return $this->getAttribute('full_name');
    }
}
