<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->createStatus("Ariza qabul qilindi",72);

        $this->createStatus("Tuman ochib ko\u{2018}rdi",72);
        $this->createStatus("Tuman tavsiyanoma yaratidi",72);
        $this->createStatus("Tuman imzolanga tavsiyanomani yukladi",60);

        $this->createStatus("Texnik tavsiyanomani ochib ko\u{2018}rdi",60);
        $this->createStatus("Texnik tavsiyanomani bekor qildi",60);
        $this->createStatus("Texnik texnik shartni yaratdi",60);
        $this->createStatus("Texnik imzolangan texnik shartni yukladi",60);
        $this->createStatus("Arizani bekor qilindi",0);

        $this->createStatus("Loyihachi loyihani yaratdi",72);
        $this->createStatus("Loyihachi muhandisga loyihani yukladi",72);

        $this->createStatus("Muhandis loyihani ochib ko\u{2018}rdi",72);
        $this->createStatus("Muhandis loyihani bekor qildi",60);
        $this->createStatus("Muhandis loyihani tasdiqladi va tasdiqlangan faylni yukladi",60);

        $this->createStatus("Montajchi loyihani ochib ko\u{2018}rdi",72);
        $this->createStatus("Montajchi ishni bajardi",72);

        $this->createStatus("Muhandis ishni ochib ko\u{2018}rdi",72);
        $this->createStatus("Muhandis montajchining ishni bekor qildi",72);
        $this->createStatus("Muhandis tasdiqlangan ishni yukladi va ruxsatnoma yaratildi",72);
        $this->createStatus("Muhandis imzolangan ruxsatnomani yukladi",72);

        $this->createStatus("Tavsiyanoma o\u{2018}chirildi",50);
        $this->createStatus("Texnik shart o\u{2018}chirildi",50);
        $this->createStatus("Loyiha o\u{2018}chirildi",50);
        $this->createStatus("Montaj o\u{2018}chirildi",50);
    }

    private function createStatus($description, $term) {
        Status::query()->create([
            'description' => $description,
            'term' => $term
        ]);
    }
}
