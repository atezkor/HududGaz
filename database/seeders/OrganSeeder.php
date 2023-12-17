<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Organ;
use Illuminate\Database\Seeder;


class OrganSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach (District::all() as $key => $model) {
            $district = explode(' ', $model->name);
            $name = $district[0][0] . '.' . strtoupper($district[1][0]) . '.' . $district[0];
            $suffix = $district[0][strlen($district[0]) - 1] == 'a' ? "yev" : "ov";
            $name .= $suffix;

            Organ::query()->create([
                'name' => $district[0] . $district[1] . "gazta\u{2019}minot",
                'tin' => rand(100, 500) + rand(100, 500) + rand(100, 500) + rand(1000, 1500),
                'district_id' => $key,
                'lead_engineer' => $name,
                'department_head' => $name,
                'address' => $district[0] . " mahallasi",
                'address_cyrill' => $model->name_cyrillic,
                'email' => strtolower($district[0] . $district[1]) . "@mail.uz",
                'phone' => "+998 (99) 215-55-0$key",
                'fax' => "+(125) 15-55"
            ]);

            if ($key == 5) {
                break;
            }
        }
    }
}
