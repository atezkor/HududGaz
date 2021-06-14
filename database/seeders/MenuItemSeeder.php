<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->adminMenu();
        $this->technicMenu();
        $this->districtMenu();
        $this->designer();
    }

    private function adminMenu() {
        $this->CreateMenuItem(1, 'admin.menu_users', 'admin.users.index', 'nav-icon fas fa-users');
        $this->CreateMenuItem(1, 'admin.menu_equips', 'admin.equipments.index', 'nav-icon fas fa-drafting-compass');
        $this->CreateMenuItem(1, 'admin.menu_designers', 'admin.designers.index', 'nav-icon fas fa-pencil-ruler');
        $this->CreateMenuItem(1, 'admin.menu_mounters', 'admin.mounters.index', 'nav-icon fas fa-network-wired');

        $this->CreateMenuItem(1, 'admin.menu_settings', '#', 'nav-icon fas fa-chart-line');
        $this->CreateMenuItem(1, 'admin.menu_org', 'admin.settings', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.menu_organs', 'admin.organs.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.menu_status', 'admin.statuses.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.menu_activity', 'admin.activities.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.menu_timetable', 'admin.timetable.index', 'nav-icon far fa-circle');
    }

    private function technicMenu() {
        $this->CreateMenuItem(2, 'technic.props', 'propositions.index', 'nav-icon fas fa-file-alt');
        $this->CreateMenuItem(2, 'technic.recommends', 'technic.recommendations', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(2, 'technic.tech_conditions', 'technic.index', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(2, 'technic.reports', '#', 'nav-icon fas fa-chart-line');
        $this->CreateMenuItem(2, 'technic.region_sec', 'propositions.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(2, 'technic.district_sec', 'propositions.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(2, 'technic.more_sec', 'propositions.index', 'nav-icon far fa-circle');
    }

    private function districtMenu() {
        $this->CreateMenuItem(3, 'district.propositions', 'district.propositions', 'badge bg-primary');
        $this->CreateMenuItem(3, 'district.recommendations', 'district.recommendations', 'badge bg-info');
        $this->CreateMenuItem(3, 'district.progress', 'district.recommendations.progress', 'badge bg-danger');
        $this->CreateMenuItem(3, 'district.cancelled', 'district.recommendations.cancelled', 'badge bg-danger');
        $this->CreateMenuItem(3, 'district.archive', 'district.recommendations.archive', 'badge bg-secondary');
    }

    private function designer() {
        $this->CreateMenuItem(4, 'designer.projects', 'designer.projects', 'badge bg-primary');
        $this->CreateMenuItem(4, 'designer.progress', 'designer.projects.progress', 'badge bg-info');
        $this->CreateMenuItem(4, 'designer.cancelled', 'designer.projects.cancelled', 'badge bg-success');
    }

    private function CreateMenuItem($role, $title, $href, $icon) {
        MenuItem::query()->firstOrCreate([
            'role' => $role,
            'title' => $title,
            'href' => $href,
            'icon' => $icon
        ]);
    }
}
