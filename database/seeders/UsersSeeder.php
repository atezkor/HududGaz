<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->creator(1, "Tizim ma\u{2019}muri", 'admin@gmail.com', 'admin');
        $this->creator(2, 'Texnik', 'technic@gmail.com', 'admin');
        $this->creator(3, 'Tuman', 'region@gmail.com', 'admin', 'uz',1);
        $this->creator(4, 'Loyihachi', 'designer@gmail.com', 'admin', 'uz', 1);
        $this->creator(5, 'Muhandis', 'engineer@gmail.com', 'admin');
        $this->creator(6, 'Montajchi', 'mounter@gmail.com', 'admin', 'uzk', 1);
    }

    private function creator($role_id, $name, $email, $password = "123456", $locale = 'uz', $organ = 0) {
        User::query()->firstOrCreate([
            'role' => $role_id,
            'name' => $name,
            'email' => $email,
            'password' => HASH::make($password),
            'locale' => $locale,
            'organ' => $organ
        ]);
    }
}
