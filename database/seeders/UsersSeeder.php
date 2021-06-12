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
        $this->creator(1, "Tizim ma\u{2019}muri", 'admin', 'admin');
        $this->creator(2, 'Texnik', 'technic', 'admin');
        $this->creator(3, 'Tuman', 'region', 'admin', 'uz',1);
        $this->creator(4, 'Loyihachi', 'designer', 'admin', 'uz', 1);
        $this->creator(5, 'Muhandis', 'engineer', 'admin');
        $this->creator(6, 'Montajchi', 'mounter', 'admin', 'uzk', 1);
    }

    private function creator($role_id, $name, $username, $password = "123456", $locale = 'uz', $organ = 0) {
        User::query()->firstOrCreate([
            'role' => $role_id,
            'name' => $name,
            'username' => $username,
            'password' => HASH::make($password),
            'locale' => $locale,
            'organ' => $organ
        ]);
    }
}
