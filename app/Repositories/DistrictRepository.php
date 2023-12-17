<?php

namespace App\Repositories;

use App\Models\District;
use Illuminate\Database\Eloquent\Collection;


class DistrictRepository {

    public function all(): Collection {
        return District::all();
    }
}
