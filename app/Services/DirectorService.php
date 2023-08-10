<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Proposition;


class DirectorService {

    public function propositions(): array {
        $models = Proposition::query()->select(
            "id",
            DB::raw("(count(id)) as count"),
            DB::raw("(DATE_FORMAT(created_at, '%m')) as month")
        )->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->get();

        $data = [];
        $j = 0;
        $count = $models->count();
        for ($i = 1; $i <= 12; $i++) {
            if ($j < $count) {
                if ((int)$models[$j]->month == $i) {
                    $data[$i] = $models[$j]->count;
                    $j++;
                    continue;
                }
            }

            $data[$i] = 0;
        }
        unset($models);

        return $data;
    }
}
