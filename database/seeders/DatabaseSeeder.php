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
        $this->call(UsersSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(HelperSeeder::class);

        $this->makeFolder();
    }

    private function makeFolder() {
        $folder = 'storage/tech_conditions';
        if (!file_exists($folder))
            File::makeDirectory($folder, 0777, true, true);

        File::makeDirectory('storage/permits', 0777, true, true);
    }
}
