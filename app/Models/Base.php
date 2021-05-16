<?php

namespace App\Models;


abstract class Base {
    public static function districts(): array { # Kalit berishning sababi tartbi 1 dan boshlanishi uchun
        return [
            1 => __('global.districts.1'),
            2 => __('global.districts.2'),
            3 => __('global.districts.3'),
            4 => __('global.districts.4'),
            5 => __('global.districts.5'),
            6 => __('global.districts.6'),
            7 => __('global.districts.7'),
            8 => __('global.districts.8'),
            9 => __('global.districts.9'),
            10 => __('global.districts.10'),
            11 => __('global.districts.11'),
            12 => __('global.districts.12'),
            13 => __('global.districts.13')
        ];
    }
}
