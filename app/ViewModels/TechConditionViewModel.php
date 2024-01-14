<?php

namespace App\ViewModels;

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
            ->with(['techCondition', 'organ:id,name'])
            ->where('status', Proposition::TC_CREATED)
            ->get(['id', 'number', 'organization_id', 'type']);
    }

    function limit() {
        return Status::query()->find(Proposition::TC_CREATED)->getAttribute('term');
    }
}
