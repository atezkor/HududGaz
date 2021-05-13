<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Base extends Model {
    public static function districts(): array { # Kalit berishning sababi tartbi 1 dan boshlanishi uchun
        return [
            1 => __('table.district.urgench_city'),
            2 => __('table.district.urgench'),
            3 => __('table.district.khiva_city'),
            4 => __('table.district.khiva'),
            5 => __('table.district.khonqa'),
            6 => __('table.district.bagat'),
            7 => __('table.district.yangiariq'),
            8 => __('table.district.yangibozor'),
            9 => __('table.district.khazorasp'),
            10 => __('table.district.shavat'),
            11 => __('table.district.gurlan'),
            12 => __('table.district.kushkupir'),
            13 => __('table.district.tupraq-kala')
        ];
    }
}
