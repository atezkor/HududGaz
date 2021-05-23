<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Region;
use Illuminate\Database\Seeder;

class HelperSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->insertOrgan();
        $this->insertActivity();
    }

    private function insertOrgan() {
        foreach (['Gurlan', "Xiva", "Urganch"] as $key => $organ) {
            Region::query()->create([
                'org_number' => rand(100, 500),
                'lead_engineer' => $organ . "bek",
                'section_leader' => $organ . "bek",
                'region' => $key + 1,
                'org_name' => $organ . "gaztaminot",
                'address' => $organ . " mahallasi",
                'address_krill' => $organ . ' bozor',
                'email' => strtolower($organ) . "@mail.uz",
                'phone' => "+(125) 15-55",
                'fax' => "+(125) 15-55"
            ]);
        }
    }

    private function insertActivity() {
        foreach (['Yakka', 'Oilaviy', 'Davalat sheriklik', 'Notijorat'] as $activity) {
            Activity::query()->create([
                'activity' => $activity
            ]);
        }
    }
}
