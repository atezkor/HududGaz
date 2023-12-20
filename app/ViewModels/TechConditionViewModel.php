<?php

namespace App\ViewModels;

use App\Models\Organ;
use App\Models\Proposition;
use App\Models\Status;
use App\Models\TechCondition;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class TechConditionViewModel extends ViewModel {

    function conditions(): Collection {
        return TechCondition::query()
            ->where('status', TechCondition::CREATED)
            ->orderBy('proposition_id')
            ->get(['id', 'created_at']);
    }

    function propositions(): Collection {
        return Proposition::query()
            ->where('status', 7)
            ->get(['id', 'number', 'organization_id', 'type']);
    }

    function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }

    function limit() {
        return Status::query()->find(7)->getAttribute('term');
    }
}
