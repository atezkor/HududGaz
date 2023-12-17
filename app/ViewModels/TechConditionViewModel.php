<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;
use App\Models\IndividualApplicant;
use App\Models\LegalApplication;
use App\Models\Proposition;
use App\Models\Organ;
use App\Models\Status;
use App\Models\TechCondition;


class TechConditionViewModel extends ViewModel {

    function conditions(): Collection {
        return $this->models(TechCondition::query(), 1, ['id', 'created_at'], 'proposition_id');
    }

    function propositions(): Collection {
        return $this->models(Proposition::query(), 7, ['id', 'number', 'organ', 'type']);
    }

    function physicals(): Collection {
        return $this->collections(IndividualApplicant::query(), 'full_name');
    }

    function legals(): Collection {
        return $this->collections(LegalApplication::query(), 'legal_name');
    }

    /** TODO
     * @param $physicals
     * @param $legals
     * @param $p
     * @param $l
     * @param $type
     * @return mixed|array|void
     */
    function applicant($physicals, $legals, &$p, &$l, $type) {
        if ($type == 1)
            return $physicals[$p++];

        return $legals[$l++];
    }

    function organs(): Collection {
        return Organ::query()->pluck('org_name', 'id');
    }

    function limit() {
        return Status::query()->find(7)->getAttribute('term');
    }

    private function models(Builder $query, $status, $attr = [], $column = 'id'): Collection { // orderlyColumn
        return $query->where('status', '=', $status)->orderBy($column)->get($attr);
    }

    private function collections(Builder $query, string $attr): Collection {
        return $query->where('status', '=', 7)->pluck($attr);
    }
}
