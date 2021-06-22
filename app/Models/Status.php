<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Status extends BaseModel {

    public $timestamps = false;
    protected $fillable = ['description', 'transitions', 'term'];
}
