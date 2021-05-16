<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Legal;
use App\Models\Base;

class PropositionListViewModel extends ViewModel {
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

    function district($district): string {
        return Base::districts()[$district];
    }
}
