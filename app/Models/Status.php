<?php

namespace App\Models;

class Status extends \Illuminate\Database\Eloquent\Model {

    public $timestamps = false;
    protected $fillable = ['description', 'transitions', 'term'];
}
