<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Timetable extends Model {

    public const TYPE_HOLIDAY = 1;
    public const TYPE_EXTRA_WORK_DAY = 2;

    protected $fillable = ['name', 'type', 'start', 'end'];
}
