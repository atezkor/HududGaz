<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class MenuItem extends Model {

    public $timestamps = false;

    public static function items($user): Builder {
        return self::query()->where('role', '=', $user->role_id);
    }
}
