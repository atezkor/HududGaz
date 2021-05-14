<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->createStatus(1, "Ariza qabul qilindi", '', 72);

        $this->createStatus(2, "Tuman ochib ko\u{2018}rdi", '', 72);
        $this->createStatus(2, "Tuman tavisyanoma yaratidi", '[1, 2, 3]', 72);
        $this->createStatus(2, "Tuman imzolanga tavsiyanomani yukladi", '[1, 2, 3]', 60);

        $this->createStatus(3, "Texnik tavsiyanomani ochib ko\u{2018}rdi", '[1, 2, 3]', 60);
        $this->createStatus(3, "Texnik tavsiyanomani bekor qildi", '[1, 2, 3]', 60);
        $this->createStatus(3, "Texnik tavsiyanomani qa\u{2019}bul qildi", '[1, 2, 3]', 60);
        $this->createStatus(3, "Texnik texnik shartni yaratdi", '[1, 2, 3]', 60);
        $this->createStatus(3, "Texnik imzolangan texnik shartni yukladi", '[1, 2, 3]', 60);
        $this->createStatus(3, "Texnik imzolangan texnik shartni yukladi va ariza bekor qilindi", '[1, 2, 3]', 60);

        $this->createStatus(4, "Loyihachi texnik shartni ochib ko\u{2018}rdi", '[1, 2, 3]', 72);
        $this->createStatus(4, "Loyihachi muhandisga loyihani yukladi", '[1, 2, 3]', 72);

        $this->createStatus(5, "Muhandis loyihani ochib ko\u{2018}rdi", '[1, 2, 3]', 72);
        $this->createStatus(5, "Muhandis loyihani bekor qildi", '[1, 2, 3]', 60);
        $this->createStatus(5, "Muhandis loyihani ID raqam bilan tasdiqladi", '[1, 2, 3]', 60);
        $this->createStatus(5, "Muhandis loyihani tasdiqlangan loyihani yukladi", '[1, 2, 3]', 60);

        $this->createStatus(6, "Montajchi loyihani ochib ko\u{2018}rdi", '[1, 2, 3]', 72);
        $this->createStatus(6, "Montajchi ishni bajardi", '[1, 2, 3]', 72);

        $this->createStatus(7, "Muhandis montajchi ishini tasdiqladi", '[1, 2, 3]', 72);
        $this->createStatus(7, "Muhandis montajchining ishni bekor qildi", '[1, 2, 3]', 72);
        $this->createStatus(7, "Muhandis ruxsatnoma berdi", '[1, 2, 3]', 72);
        $this->createStatus(7, "Muhandis imzolangan ruxsatnomani yukladi", '[1, 2, 3]', 72);

        $this->createStatus(8, "Tavsiyanoma o\u{2018}chirildi", '[1, 2, 3]', 72);
        $this->createStatus(8, "Texnik shart o\u{2018}chirildi", '[1, 2, 3]', 72);
        $this->createStatus(8, "Loyiha o\u{2018}chirildi", '[1, 2, 3]', 72);
        $this->createStatus(8, "Montaj o\u{2018}chirildi", '[1, 2, 3]', 72);
    }

    private function createStatus($code, $description, $transitions, $term) {
        Status::query()->create([
            'code' => $code,
            'description' => $description,
            'transitions' => $transitions,
            'term' => $term
        ]);
    }
}
