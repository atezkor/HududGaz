<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->creator(1, 'admin', 'admin@gmail.com', 'admin');
        $this->creator(2, 'technic', 'technic@gmail.com', 'admin');
        $this->creator(3, 'region', 'region@gmail.com', 'admin');
        $this->creator(4, 'designer', 'designer@gmail.com', 'admin');
        $this->creator(5, 'engineer', 'engineer@gmail.com', 'admin');
        $this->creator(6, 'mounter', 'mounter@gmail.com', 'admin', 'uzk', 'profile.jpg');
    }

    private function creator($role_id, $name, $email, $password = "123456", $locale = 'uz', $avatar = 'profile.png') {
        User::query()->firstOrCreate([
            'role' => $role_id,
            'name' => $name,
            'email' => $email,
            'password' => HASH::make($password),
            'locale' => $locale,
            'avatar' => $avatar
        ]);
    }
}
