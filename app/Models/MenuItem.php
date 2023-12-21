<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class MenuItem extends Model {

    public $timestamps = false;

    public static function items(int $roleId): Builder {
        return self::query()->where('role', $roleId);
    }
}
