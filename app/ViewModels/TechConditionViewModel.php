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
        return $this->models(TechCondition::query(), 1, ['id', 'created_at'],'proposition_id');
    }

    function propositions(): Collection {
        return $this->models(Proposition::query(), 7, ['id', 'number', 'organ', 'type']);
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

    private function models(Builder $query, $status, $attr = [], $order = 'id'): Collection {
        return $query->where('status', '=', $status)->orderBy($order)->get($attr);
    }

    private function collections(Builder $query, string $attr): Collection {
        return $query->where('status', '=', 7)->pluck($attr);
    }
}
