<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\User;
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
        $this->organMenuItems();
        $this->designer();
        $this->engineer();
        $this->mounterMenu();
        $this->directorMenu();
    }

    private function adminMenu() {
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.users', 'admin.users.index', 'nav-icon fas fa-users');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.organs', 'admin.organs.index', 'nav-icon far fa-building');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.designers', 'admin.designers.index', 'nav-icon fas fa-pencil-ruler');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.mounters', 'admin.mounters.index', 'nav-icon fas fa-network-wired');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.equipment_types', 'admin.equipment-types.index', 'nav-icon fas fa-drafting-compass');

        $this->createMenuItem(User::ROLE_ADMIN, 'admin.settings', '#', 'nav-icon fas fa-chart-line');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.about_org', 'admin.settings', 'nav-icon far fa-circle');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.statuses', 'admin.statuses.index', 'nav-icon far fa-circle');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.activities', 'admin.activities.index', 'nav-icon far fa-circle');
        $this->createMenuItem(User::ROLE_ADMIN, 'admin.timetables', 'admin.timetable.index', 'nav-icon far fa-circle');
    }

    private function technicMenu() {
        $this->createMenuItem(User::TECHNIC, 'technic.props', 'propositions.index', 'nav-icon fas fa-file-alt');
        $this->createMenuItem(User::TECHNIC, 'technic.recommends', 'technic.recommendations', 'nav-icon fas fa-paste');
        $this->createMenuItem(User::TECHNIC, 'technic.tech_conditions', 'technic.index', 'nav-icon fas fa-paste');
        $this->createMenuItem(User::TECHNIC, 'technic.reports', '#', 'nav-icon fas fa-chart-line');
        $this->createMenuItem(User::TECHNIC, 'technic.region_sec', 'technic.reg_section', 'nav-icon far fa-circle');
        $this->createMenuItem(User::TECHNIC, 'technic.organ_sec', 'technic.org_section', 'nav-icon far fa-circle');
        $this->createMenuItem(User::TECHNIC, 'technic.more_sec', 'technic.more', 'nav-icon far fa-circle');
    }

    private function organMenuItems() {
        $this->createMenuItem(User::ORGAN, 'organ.propositions', 'organ.propositions', 'bg-primary');
        $this->createMenuItem(User::ORGAN, 'organ.recommendations', 'organ.recommendations', 'bg-info');
        $this->createMenuItem(User::ORGAN, 'organ.progress', 'organ.recommendations.progress', 'bg-success');
        $this->createMenuItem(User::ORGAN, 'organ.cancelled', 'organ.recommendations.cancelled', 'bg-danger');
        $this->createMenuItem(User::ORGAN, 'organ.archive', 'organ.recommendations.archive', 'bg-secondary');
    }

    private function designer() {
        $this->createMenuItem(User::DESIGNER, 'designer.projects', 'designer.projects', 'bg-primary');
        $this->createMenuItem(User::DESIGNER, 'designer.process', 'designer.projects.process', 'bg-info');
        $this->createMenuItem(User::DESIGNER, 'designer.cancelled', 'designer.projects.cancelled', 'bg-danger');
        $this->createMenuItem(User::DESIGNER, 'designer.accomplished', 'designer.projects.accomplished', 'bg-success');
    }

    private function engineer() {
        $this->createMenuItem(User::ENGINEER, 'engineer.projects', 'engineer.projects', 'nav-icon fas fa-drafting-compass');
        $this->createMenuItem(User::ENGINEER, 'engineer.montages', 'engineer.montages', 'nav-icon fas fa-network-wired');
        $this->createMenuItem(User::ENGINEER, 'engineer.permits', 'engineer.permits', 'nav-icon fas fa-copy');
        $this->createMenuItem(User::ENGINEER, 'engineer.archive', '#', 'nav-icon fas fa-box-open');
        $this->createMenuItem(User::ENGINEER, 'engineer.projects', 'engineer.projects.archive', 'nav-icon far fa-circle');
        $this->createMenuItem(User::ENGINEER, 'engineer.montages', 'engineer.montages.archive', 'nav-icon far fa-circle');
    }

    private function mounterMenu() {
        $this->createMenuItem(User::MOUNTER, 'mounter.montages', 'mounter.montages', 'bg-primary');
        $this->createMenuItem(User::MOUNTER, 'mounter.process', 'mounter.process', 'bg-info');
        $this->createMenuItem(User::MOUNTER, 'mounter.cancelled', 'mounter.cancelled', 'bg-danger');
        $this->createMenuItem(User::MOUNTER, 'mounter.accomplished', 'mounter.archive', 'bg-success');
    }

    private function directorMenu() {
        $this->createMenuItem(User::DIRECTOR, 'global.statistics', 'director.index', 'nav-icon fas fa-chart-bar');
        $this->createMenuItem(User::DIRECTOR, 'admin.users', 'director.users', 'nav-icon fas fa-users');
        $this->createMenuItem(User::DIRECTOR, 'admin.organs', 'director.organs', 'nav-icon fas fa-landmark');
        $this->createMenuItem(User::DIRECTOR, 'admin.designers', 'director.designers', 'nav-icon fas fa-drafting-compass');
        $this->createMenuItem(User::DIRECTOR, 'admin.mounters', 'director.installers', 'nav-icon fas fa-network-wired');
        $this->createMenuItem(User::DIRECTOR, 'global.documents', '#', 'nav-icon fas fa-folder-open');
        $this->createMenuItem(User::DIRECTOR, 'global.propositions', 'director.propositions', 'nav-icon fas fa-paste');
        $this->createMenuItem(User::DIRECTOR, 'district.recommendations', 'director.recommendations', 'nav-icon fas fa-paste');
        $this->createMenuItem(User::DIRECTOR, 'technic.tech_conditions', 'director.tech_conditions', 'nav-icon fas fa-paste');
        $this->createMenuItem(User::DIRECTOR, 'designer.projects', 'director.projects', 'nav-icon fas fa-paste');
        $this->createMenuItem(User::DIRECTOR, 'mounter.montages', 'director.montages', 'nav-icon fas fa-paste');
        $this->createMenuItem(User::DIRECTOR, 'engineer.permits', 'director.permits', 'nav-icon fas fa-paste');
    }

    private function createMenuItem($role, $title, $href, $icon) {
        MenuItem::query()->firstOrCreate([
            'role' => $role,
            'title' => $title,
            'href' => $href,
            'icon' => $icon
        ]);
    }
}
