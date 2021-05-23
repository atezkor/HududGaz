<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Base;
use App\Models\Individual;
use App\Models\Legal;
use App\Models\Proposition;
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
        $this->insertProposition();
    }

    private function insertOrgan() {
        foreach (Base::districts() as $key => $organ) {
            $district = explode(' ', $organ);
            $name = $district[0][0] . '.' . strtoupper($district[1][0]) . '.' . $district[0];
            $suffix = $district[0][strlen($district[0]) - 1] == 'a' ? "yev" : "ov";
            $name .= $suffix;
            Region::query()->create([
                'org_number' => rand(100, 500),
                'lead_engineer' =>  $name,
                'section_leader' => $name,
                'region' => $key,
                'org_name' => $district[0] . $district[1] . "gazta\u{2019}minot",
                'address' => $district[0] . " mahallasi",
                'address_krill' => $organ . ' bozori',
                'email' => strtolower($district[0] . $district[1]) . "@mail.uz",
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

    private function insertProposition() {
        foreach (['Anvar', 'Abror', 'Olloshukur', 'Bekdiyor'] as $key => $applicant) {
            Proposition::query()->create([
                'number' => rand(1000, 5000),
                'organ' => $key + 1,
                'activity_type' => $key + 1,
                'build_type' => rand(1, 2),
                'type' => 2,
                'status' => 1,
                'file' => time() . '.pdf'
            ]);

            Legal::query()->create([
                'proposition_id' => $key + 1,
                'legal_stir' => rand(1000, 5000) + rand(1000, 5000),
                'legal_name' => $applicant . ' Industries',
                'email' => strtolower($applicant) . '@mail.uz',
                'leader' => $applicant,
                'leader_stir' => rand(1000, 5000) + rand(1000, 5000),
                'phone' => "+998 99 555 15 55"
            ]);
        }

        foreach (['Bekzod', 'Mirzabek', 'Dilshod', 'Temur'] as $key => $applicant) {
            Proposition::query()->create([
                'number' => rand(100, 500),
                'organ' => $key + 5,
                'activity_type' => $key + 1,
                'build_type' => rand(1, 2),
                'type' => 1,
                'status' => 1,
                'file' => time() . '.pdf'
            ]);

            Individual::query()->create([
                'proposition_id' => $key + 5,
                'full_name' => $applicant,
                'phone' => "+998 99 555 15 55",
                'passport' => "AB8674" . rand(101, 999),
                'stir' => rand(1000, 5000) + rand(1000, 5000),
            ]);
        }
    }
}
