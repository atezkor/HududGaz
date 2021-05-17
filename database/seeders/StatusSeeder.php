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
        $this->createStatus("Ariza qabul qilindi", '', 72);

        $this->createStatus("Tuman ochib ko\u{2018}rdi", '', 72);
        $this->createStatus("Tuman tavsiyanoma yaratidi", '[1, 2, 3]', 72);
        $this->createStatus("Tuman imzolanga tavsiyanomani yukladi", '[1, 2, 3]', 60);

        $this->createStatus("Texnik tavsiyanomani ochib ko\u{2018}rdi", '[1, 2, 3]', 60);
        $this->createStatus("Texnik tavsiyanomani bekor qildi", '[1, 2, 3]', 60);
        $this->createStatus("Texnik tavsiyanomani qa\u{2019}bul qildi", '[1, 2, 3]', 60);
        $this->createStatus("Texnik texnik shartni yaratdi", '[1, 2, 3]', 60);
        $this->createStatus("Texnik imzolangan texnik shartni yukladi", '[1, 2, 3]', 60);
        $this->createStatus("Texnik imzolangan texnik shartni yukladi va ariza bekor qilindi", '[1, 2, 3]', 60);

        $this->createStatus("Loyihachi texnik shartni ochib ko\u{2018}rdi", '[1, 2, 3]', 72);
        $this->createStatus("Loyihachi muhandisga loyihani yukladi", '[1, 2, 3]', 72);

        $this->createStatus("Muhandis loyihani ochib ko\u{2018}rdi", '[1, 2, 3]', 72);
        $this->createStatus("Muhandis loyihani bekor qildi", '[1, 2, 3]', 60);
        $this->createStatus("Muhandis loyihani ID raqam bilan tasdiqladi", '[1, 2, 3]', 60);
        $this->createStatus("Muhandis loyihani tasdiqlangan loyihani yukladi", '[1, 2, 3]', 60);

        $this->createStatus("Montajchi loyihani ochib ko\u{2018}rdi", '[1, 2, 3]', 72);
        $this->createStatus("Montajchi ishni bajardi", '[1, 2, 3]', 72);

        $this->createStatus("Muhandis montajchi ishini tasdiqladi", '[1, 2, 3]', 72);
        $this->createStatus("Muhandis montajchining ishni bekor qildi", '[1, 2, 3]', 72);
        $this->createStatus("Muhandis ruxsatnoma berdi", '[1, 2, 3]', 72);
        $this->createStatus("Muhandis imzolangan ruxsatnomani yukladi", '[1, 2, 3]', 72);

        $this->createStatus("Tavsiyanoma o\u{2018}chirildi", '[1, 2, 3]', 72);
        $this->createStatus("Texnik shart o\u{2018}chirildi", '[1, 2, 3]', 72);
        $this->createStatus("Loyiha o\u{2018}chirildi", '[1, 2, 3]', 72);
        $this->createStatus("Montaj o\u{2018}chirildi", '[1, 2, 3]', 72);
    }

    private function createStatus($description, $transitions, $term) {
        Status::query()->create([
            'description' => $description,
            'transitions' => $transitions,
            'term' => $term
        ]);
    }
}
