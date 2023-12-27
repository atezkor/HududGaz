<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Application;
use App\Models\Designer;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\LegalApplicant;
use App\Models\Mounter;
use App\Models\PhysicalApplicant;
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
        $this->insertMontunter();

        $this->insertEquipmentTypes();
        $this->insertEquipment();
    }

    private function insertActivity() {
        foreach (['Aholi xonadonlari', 'Yakka', 'Oilaviy', 'Davalat sheriklik', 'Notijorat'] as $activity) {
            Activity::query()->create([
                'activity' => $activity
            ]);
        }
    }

    private function insertProposition() {
        $appLegalList = ['Anvar', 'Abror'];
        $appPhysicalList = ['Bekdiyor', 'Mirzabek'];

        foreach ($appLegalList as $key => $applicant) {
            $model = Proposition::query()->create([
                'number' => rand(1000, 5000) + rand(100, 500),
                'organization_id' => 1,
                'type' => Application::LEGAL,
                'build_type' => rand(1, 2),
                'activity_type_id' => $key + 1,
                'pdf' => 'test.pdf'
            ]);

            LegalApplicant::query()->create([
                'proposition_id' => $model->id,
                'tin' => rand(100000000, 1000000000),
                'name' => $applicant . ' Industries',
                'phone' => "+998 99 555 15 55",
                'email' => strtolower($applicant) . '@mail.uz',
                'director' => $applicant,
                'director_pin_fl' => rand(100, 1000000000) . rand(100, 100000)
            ]);
        }

        foreach ($appPhysicalList as $key => $applicant) {
            $model = Proposition::query()->create([
                'number' => rand(1000, 5000) + rand(100, 500),
                'organization_id' => 1,
                'type' => Application::PHYSICAL,
                'build_type' => rand(1, 2),
                'activity_type_id' => $key + 1,
                'pdf' => 'test.pdf'
            ]);

            PhysicalApplicant::query()->create([
                'proposition_id' => $model->id,
                'name' => $applicant,
                'surname' => "",
                'phone' => "+998 99 555 15 55",
                'passport' => "AB8674" . rand(101, 999),
                'tin' => rand(100000000, 1000000000),
                'pin_fl' => rand(100000000, 1000000000) . rand(10000, 100000)
            ]);
        }
    }

    private function insertEquipmentTypes() {
        foreach (["Gaz-hisoblagich", "Gaz qozoni", 'Gaz quvuri', "Jo\u{2018}mrak"] as $equip) {
            EquipmentType::query()->create([
                'name' => $equip
            ]);
        }
    }

    private function insertEquipment() {
        Equipment::query()->create([
            'name' => 'PRINTS-G10',
            'equipment_type_id' => 1
        ]);
    }

    private function insertDesigner() {
        foreach (['IDEAL TARMOQ LOYIHA'] as $designer) {
            Designer::query()->create([
                'name' => $designer,
                'director' => 'L.L.Loyihachi',
                'phone' => '+998 99 555 15 55',
                'address' => 'Mahalla',
                'address_cyrill' => 'Mahalla',
                'registry_date' => now(),
                'expiry_date' => date('Y-m-d', time() + 3600 * 24 * 356),
                'license' => 'qwerty.pdf'
            ]);
        }
    }

    private function insertMontunter() {
        foreach (['MONTAJ SERVICE SIFAT'] as $firm) {
            Mounter::query()->create([
//                'license' => []
                'full_name' => $firm,
                'short_name' => $firm,
                'director' => 'M.M.Montajchi',
                'tin' => rand(1000, 5000) + rand(100, 500),
                'rec_num' => rand(1000, 5000) + rand(100, 500),
                'reg_num' => rand(1000, 5000) + rand(100, 500),
                'district_id' => rand(1, 13),
                'phone' => '+998 99 555 15 55',
                'address' => 'Mahalla',
                'date_registry' => now(),
                'date_expiry' => date('Y-m-d', time() + 3600 * 24 * 356),
                'given_by' => 'Davlat xizmatlari markazi',
                'permissions' => "barcha gaz inshootlarini o\u{2018}rnatish va ta\u{2019}mirlash, gaz quvurlarini ishlatish tekshirish",
                'implementations' => "yuqori, o\u{2018}rta va past bosimli gaz inshootlarining yer osti va usti gaz quvurlarini ishga tushirish zamin quvurlarini o\u{2018}rnatish, ta\u{2019}mirlash ishlari",
                'license' => 'license.pdf'
            ]);
        }
    }
}
