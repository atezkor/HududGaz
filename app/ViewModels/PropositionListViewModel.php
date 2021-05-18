<?php

namespace App\ViewModels;

use App\Models\Region;
use Spatie\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Legal;

class PropositionListViewModel extends ViewModel {

    private Collection $organs;
    public function __construct() {
        $this->organs = Region::query()->get(['id', 'org_name']);
    }

    function individuals(): Collection {
        return Proposition::query()->where('type', '=', 1)->get();
    }

    function physicals(): Collection {
        return Individual::all();
    }

    function legalEntities(): Collection {
        return Proposition::query()->where('type', '=', 2)->get();
    }

    function legals(): Collection {
        return Legal::all();
    }

    function organ($organ): string {
        return $this->organs[$organ]->org_name;
    }
}
