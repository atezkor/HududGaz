<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->creator(1, 'admin', 'admin@mail.com', 'admin');
        $this->creator(2, 'technic', 'technic@mail.com', 'admin');
        $this->creator(3, 'region', 'technic@mail.com', 'admin');
        $this->creator(4, 'designer', 'technic@mail.com', 'admin');
        $this->creator(5, 'engineer', 'technic@mail.com', 'admin');
        $this->creator(6, 'director', 'technic@mail.com', 'admin', 'uz', 'profile.jpg');
        $this->creator(7, 'montage_firm', 'technic@mail.com', 'admin');
    }

    private function creator($role_id, $name, $email, $password = "123456", $locale = 'uzk', $avatar = 'profile.png') {
        User::query()->firstOrCreate([
            'role_id' => $role_id,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'locale' => $locale,
            'avatar' => $avatar
        ]);
    }
}
