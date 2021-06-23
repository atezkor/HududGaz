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
        $this->generate(1, 'edit_profile');
        $this->generate(1, 'crud_user');
        $this->generate(1, 'be_admin');
    }

    private function technic() {
        $this->generate(2, 'edit_profile');
        $this->generate(2, 'crud_prop');
        $this->generate(2, 'crud_tech');
        $this->generate(2, 'show_report');
    }

    private function organ() {
        $this->generate(3, 'edit_profile');
        $this->generate(3, 'crud_rec');
    }

    private function designer() {
        $this->generate(4, 'edit_profile');
        $this->generate(4, 'crud_project');
    }

    private function engineer() {
        $this->generate(5, 'edit_profile');
        $this->generate(5, 'crud_permit');
    }

    private function installer() {
        $this->generate(6, 'edit_profile');
        $this->generate(6, 'crud_montage');
    }

    private function director() {
        $this->generate(7, 'edit_profile');
        $this->generate(7, 'res_admin'); // resource admin
        $this->generate(7, 'show_document');
    }

    private function generate(int $role, string $name) {
        Permission::query()->firstOrCreate([
            'role' => $role,
            'name' => $name
        ]);
    }
}
