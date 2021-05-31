<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService extends CrudService {

    public function __construct(User $user) {
        $this->model = $user;
    }

    public function create($data) {
        $data['password'] = $this->hashed($data['password']);
        parent::create($data);
    }

    public function update($data, $model) {
        $data['password'] = $this->hashed($data['password']);
        parent::update($data, $model);
    }

    private function hashed(string $password): string {
        return Hash::make($password);
    }
}
