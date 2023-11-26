<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


class UserRepository {

    public function users(): Collection {
        return User::query()->where('role_id', '<>', User::ROLE_ADMIN)->get();
    }
}
