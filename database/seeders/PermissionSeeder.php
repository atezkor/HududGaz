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
        $this->generate(1, 'crud_organ');
        $this->generate(1, 'crud_equipment');
        $this->generate(1, 'crud_designer');
        $this->generate(1, 'crud_installer');
        $this->generate(1, 'crud_setting'); // setting
        $this->generate(1, 'crud_status');
        $this->generate(1, 'crud_activity');
        $this->generate(1, 'crud_time');
    }

    private function technic() {
        $this->generate(2, 'show');
    }

    private function organ() {

    }

    private function designer() {

    }

    private function engineer() {

    }

    private function installer() {

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
