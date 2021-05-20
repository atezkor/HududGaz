<?php

namespace App\Services;

use App\Models\User;

class UserService extends CrudService {

    public function __construct(User $user) {
        $this->model = $user;
    }
}
