<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->create(User::ROLE_ADMIN, "Tizim ma\u{2019}muri", 'admin', 'admin');
        $this->create(User::TECHNIC, 'Texnik', 'technic', 'admin');
        $this->create(User::ORGAN, 'Tuman', 'organ', 'admin', 'uz', 1);
        $this->create(User::DESIGNER, 'Loyihachi', 'designer', 'admin', 'uz', 1);
        $this->create(User::ENGINEER, 'Muhandis', 'engineer', 'admin');
        $this->create(User::MOUNTER, 'Montajchi', 'mounter', 'admin', 'uzk', 1);
        $this->create(User::DIRECTOR, 'Direktor', 'director', 'director', 'uzk');
    }

    private function create(int $roleId, string $name, string $username, string $password, $locale = 'uz', $organizationId = null) {
        User::query()->firstOrCreate([
            'name' => $name,
            'username' => $username,
            'password' => HASH::make($password),
            'role_id' => $roleId,
            'organization_id' => $organizationId,
            'locale' => $locale
        ]);
    }
}
