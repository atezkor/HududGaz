<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Status extends Model {

    public $timestamps = false;

    protected $fillable = ['description', 'transitions', 'term'];
}
