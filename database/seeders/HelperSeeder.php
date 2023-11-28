<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Designer;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\IndividualApplication;
use App\Models\LegalApplication;
use App\Models\Mounter;
use App\Models\Proposition;
use Illuminate\Database\Seeder;


class HelperSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->insertActivity();
        $this->insertProposition();
        $this->insertDesigner();
        $this->insertMontageFirm();

        $this->insertEquipmentTypes();
//        $this->insertEquipment();
    }

    private function insertActivity() {
        foreach (['Aholi xonadonlari', 'Yakka', 'Oilaviy', 'Davalat sheriklik', 'Notijorat'] as $activity) {
            Activity::query()->create([
                'activity' => $activity
            ]);
        }
    }

    private function insertProposition() {
        foreach (['Anvar', 'Abror', 'Olloshukur', 'Bekdiyor'] as $key => $applicant) {
            Proposition::query()->create([
                'number' => rand(1000, 5000) + rand(100, 500),
                'organ' => 1, # $key + 1
                'activity_type' => $key + 1,
                'build_type' => rand(1, 2),
                'type' => 2,
                'status' => 1,
                'file' => 'test.pdf'
            ]);

            LegalApplication::query()->create([
                'proposition_id' => $key + 1,
                'organ' => 1,
                'legal_stir' => rand(1000, 5000) + rand(100, 500),
                'legal_name' => $applicant . ' Industries',
                'email' => strtolower($applicant) . '@mail.uz',
                'leader' => $applicant,
                'leader_stir' => rand(1000, 5000) + rand(1000, 5000),
                'phone' => "+998 99 555 15 55"
            ]);
        }

        foreach (['Bekzod', 'Mirzabek', 'Dilshod', 'Temur'] as $key => $applicant) {
            Proposition::query()->create([
                'number' => rand(1000, 5000) + rand(100, 500),
                'organ' => 1, # $key + 5
                'activity_type' => $key + 1,
                'build_type' => rand(1, 2),
                'type' => 1,
                'status' => 1,
                'file' => 'test.pdf'
            ]);

            IndividualApplication::query()->create([
                'proposition_id' => $key + 5,
                'organ' => 1,
                'full_name' => $applicant,
                'phone' => "+998 99 555 15 55",
                'passport' => "AB8674" . rand(101, 999),
                'stir' => rand(1000, 5000) + rand(1000, 5000),
            ]);
        }
    }

    private function insertEquipmentTypes() {
        foreach (["Gaz-hisoblagich"] as $name) {
            EquipmentType::query()->create([
                'name' => $name,
                'static' => true
            ]);
        }

        foreach (["Gaz qozoni", 'Gaz quvuri', "Jo\u{2018}mrak"] as $equip) {
            EquipmentType::query()->create([
                'name' => $equip,
            ]);
        }
    }

    private function insertEquipment() {
        foreach (['PRINTS-G10'] as $key => $type) {
            Equipment::query()->create([
                'type' => $type,
                'equipment_id' => $key + 1,
                'order' => 1
            ]);
        }
    }

    private function insertDesigner() {
        foreach (['IDEAL TARMOQ LOYIHA'] as $designer) {
            Designer::query()->create([
                'org_name' => $designer,
                'leader' => 'L.L.Loyihachi',
                'phone' => '+998 99 555 15 55',
                'address' => 'Mahalla',
                'address_krill' => 'Mahalla',
                'date_reg' => now(),
                'date_end' => date('Y-m-d', time() + 3600 * 24 * 356),
                'document' => 'qwerty.pdf'
            ]);
        }
    }

    private function insertMontageFirm() {
        foreach (['MONTAJ SERVICE SIFAT'] as $montage_firm) {
            Mounter::query()->create([
                'rec_num' => rand(1000, 5000) + rand(100, 500),
                'reg_num' => rand(1000, 5000) + rand(100, 500),
                'full_name' => $montage_firm,
                'short_name' => $montage_firm,
                'leader' => 'M.M.Montajchi',
                'district' => rand(1, 13),
                'phone' => '+998 99 555 15 55',
                'address' => 'Mahalla',
                'taxpayer_stir' => rand(1000, 5000) + rand(100, 500),
                'date_created' => now(),
                'date_expired' => date('Y-m-d', time() + 3600 * 24 * 356),
                'given_by' => 'Davlat xizmatlari markazi',
                'permission_to' => "barcha gaz inshootlarini o\u{2018}rnatish va ta\u{2019}mirlash, gaz quvurlarini ishlatish tekshirish",
                'implement_for' => "yuqori, o\u{2018}rta va past bosimli gaz inshootlarining yer osti va usti gaz quvurlarini ishga tushirish zamin quvurlarini o\u{2018}rnatish, ta\u{2019}mirlash ishlari",
                'document' => 'qwerty.pdf'
            ]);
        }
    }
}
