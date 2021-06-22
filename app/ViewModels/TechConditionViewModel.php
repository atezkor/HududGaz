<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Legal;
use App\Models\TechCondition;
use App\Models\Region;
use App\Models\Status;
use Spatie\ViewModels\ViewModel;

class TechConditionViewModel extends ViewModel {

    function conditions(): Collection {
        return TechCondition::query()->where('status', 1)->orderBy('proposition_id')->pluck('id');
    }

    function propositions(): Collection {
        return $this->models(Proposition::query());
    }

    function physicals(): Collection {
        return $this->collections(Individual::query(), 'full_name');
    }

    function legals(): Collection {
        return $this->collections(Legal::query(), 'legal_name');
    }

    function applicant($physicals, $legals, &$p, &$l, $type) {
        if ($type == 1)
            return $physicals[$p ++];

        return $legals[$l ++];
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    function limit() {
        return Status::query()->find(7)->getAttribute('term');
    }

    private function models(Builder $query): Collection { // int $status = 7
        return $query->where('status', '=', 7)->get(['id', 'number', 'organ', 'type', 'created_at']);
    }

    private function collections(Builder $query, string $attr, int $status = 7): Collection {
        return $query->where('status', '=', $status)->pluck($attr);
    }
}
