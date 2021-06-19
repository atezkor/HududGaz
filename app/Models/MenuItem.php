<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class MenuItem extends \Illuminate\Database\Eloquent\Model {
    public $timestamps = false;

    public static function items($user): Builder {
        return self::query()->where('role', '=', $user->role);
    }
}
