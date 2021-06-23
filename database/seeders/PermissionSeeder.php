<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->admin();
        $this->technic();
        $this->organ();
        $this->designer();
        $this->engineer();
        $this->installer();
        $this->director();
    }

    private function admin() {
        $this->generate(1, 'crud_user');
        $this->generate(1, 'be_admin');
        $this->generate(1, 'edit_profile');
    }

    private function technic() {
        $this->generate(2, 'edit_profile');
    }

    private function organ() {
        $this->generate(3, 'edit_profile');
        $this->generate(3, 'crud_rec');
    }

    private function designer() {
        $this->generate(4, 'edit_profile');
    }

    private function engineer() {
        $this->generate(5, 'edit_profile');
    }

    private function installer() {
        $this->generate(6, 'edit_profile');
    }

    private function director() {
        $this->generate(7, 'show_user');
        $this->generate(7, 'show_organ');
        $this->generate(7, 'show_designer');
        $this->generate(7, 'show_installer');
    }

    private function generate(int $role, string $name) {
        Permission::query()->firstOrCreate([
            'role' => $role,
            'name' => $name
        ]);
    }
}
