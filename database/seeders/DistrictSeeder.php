<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $list = [
            "Urganch shahri",
            "Urganch tumani",
            "Xiva shahri",
            "Xiva tumani",
            "Xonqa tumani",
            "Bog\u{2018}ot tumani",
            "Yangiariq tumani",
            "Yangibozor tumani",
            "Xozarasp tumani",
            "Shovot tumani",
            "Gurlan tumani",
            "Qo\u{2018}shko\u{2018}pir tumani",
            "Tuproq-qa\u{2019}la tumani"
        ];

        foreach ($list as $district) {
            District::query()->create([
                'name' => $district,
                'name_cyrillic' => $district
            ]);
        }
    }
}
