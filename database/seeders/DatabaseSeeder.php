<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UserSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(HelperSeeder::class);
        $this->call(PermissionSeeder::class);

        // $this->makeFolder();
    }

    private function makeFolder() {
        $folder = 'public/storage/tech_conditions';
        if (!file_exists($folder))
            File::makeDirectory($folder, 0777, true, true);

        File::makeDirectory('public/storage/permits', 0777, true, true);
    }
}
