<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

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
        $this->engineer();
        $this->mounterMenu();
        $this->directorMenu();
    }

    private function adminMenu() {
        $this->CreateMenuItem(1, 'admin.users', 'admin.users.index', 'nav-icon fas fa-users');
        $this->CreateMenuItem(1, 'admin.equips', 'admin.equipments.index', 'nav-icon fas fa-drafting-compass');
        $this->CreateMenuItem(1, 'admin.designers', 'admin.designers.index', 'nav-icon fas fa-pencil-ruler');
        $this->CreateMenuItem(1, 'admin.mounters', 'admin.mounters.index', 'nav-icon fas fa-network-wired');

        $this->CreateMenuItem(1, 'admin.settings', '#', 'nav-icon fas fa-chart-line');
        $this->CreateMenuItem(1, 'admin.org_about', 'admin.settings', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.organs', 'admin.organs.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.statuses', 'admin.statuses.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.activities', 'admin.activities.index', 'nav-icon far fa-circle');
        $this->CreateMenuItem(1, 'admin.timetables', 'admin.timetable.index', 'nav-icon far fa-circle');
    }

    private function technicMenu() {
        $this->CreateMenuItem(2, 'technic.props', 'propositions.index', 'nav-icon fas fa-file-alt');
        $this->CreateMenuItem(2, 'technic.recommends', 'technic.recommendations', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(2, 'technic.tech_conditions', 'technic.index', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(2, 'technic.reports', '#', 'nav-icon fas fa-chart-line');
        $this->CreateMenuItem(2, 'technic.region_sec', 'technic.reg_section', 'nav-icon far fa-circle');
        $this->CreateMenuItem(2, 'technic.organ_sec', 'technic.org_section', 'nav-icon far fa-circle');
        $this->CreateMenuItem(2, 'technic.more_sec', 'technic.more', 'nav-icon far fa-circle');
    }

    private function districtMenu() {
        $this->CreateMenuItem(3, 'district.propositions', 'district.propositions', 'bg-primary');
        $this->CreateMenuItem(3, 'district.recommendations', 'district.recommendations', 'bg-info');
        $this->CreateMenuItem(3, 'district.progress', 'district.recommendations.progress', 'bg-success');
        $this->CreateMenuItem(3, 'district.cancelled', 'district.recommendations.cancelled', 'bg-danger');
        $this->CreateMenuItem(3, 'district.archive', 'district.recommendations.archive', 'bg-secondary');
    }

    private function designer() {
        $this->CreateMenuItem(4, 'designer.projects', 'designer.projects', 'bg-primary');
        $this->CreateMenuItem(4, 'designer.process', 'designer.projects.process', 'bg-info');
        $this->CreateMenuItem(4, 'designer.cancelled', 'designer.projects.cancelled', 'bg-danger');
        $this->CreateMenuItem(4, 'designer.accomplished', 'designer.projects.accomplished', 'bg-success');
    }

    private function engineer() {
        $this->CreateMenuItem(5, 'engineer.projects', 'engineer.projects', 'nav-icon fas fa-drafting-compass');
        $this->CreateMenuItem(5, 'engineer.montages', 'engineer.montages', 'nav-icon fas fa-network-wired');
        $this->CreateMenuItem(5, 'engineer.permits', 'engineer.permits', 'nav-icon fas fa-copy');
        $this->CreateMenuItem(5, 'engineer.archive', '#', 'nav-icon fas fa-box-open');
        $this->CreateMenuItem(5, 'engineer.projects', 'engineer.projects.archive', 'nav-icon far fa-circle');
        $this->CreateMenuItem(5, 'engineer.montages', 'engineer.montages.archive', 'nav-icon far fa-circle');
    }

    private function mounterMenu() {
        $this->CreateMenuItem(6, 'mounter.montages', 'mounter.montages', 'bg-primary');
        $this->CreateMenuItem(6, 'mounter.process', 'mounter.process', 'bg-info');
        $this->CreateMenuItem(6, 'mounter.cancelled', 'mounter.cancelled', 'bg-danger');
        $this->CreateMenuItem(6, 'mounter.accomplished', 'mounter.archive', 'bg-success');
    }

    private function directorMenu() {
        $this->CreateMenuItem(7, 'admin.organs', 'director.organs', 'nav-icon fas fa-copy');
        $this->CreateMenuItem(7, 'admin.designers', 'director.designers', 'nav-icon fas fa-copy');
        $this->CreateMenuItem(7, 'admin.mounters', 'director.installers', 'nav-icon fas fa-copy');
        $this->CreateMenuItem(7, 'global.documents', '#', 'nav-icon fas fa-folder-open');
        $this->CreateMenuItem(7, 'global.propositions', 'director.propositions', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(7, 'district.recommendations', 'director.recommendations', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(7, 'technic.tech_conditions', 'director.tech_conditions', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(7, 'designer.projects', 'director.projects', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(7, 'mounter.montages', 'director.montages', 'nav-icon fas fa-paste');
        $this->CreateMenuItem(7, 'engineer.permits', 'director.permits', 'nav-icon fas fa-paste');
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
