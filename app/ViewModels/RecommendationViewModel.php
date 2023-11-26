<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Models;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;
use App\Models\{IndividualApplication, LegalApplication, Proposition, Recommendation, Organ};


class RecommendationViewModel extends ViewModel {
    private array $prop_status;
    private int $status;
    private int $organ;
    private string $operator = '>';

    public function __construct(array $prop_status = [3], int $status = 1, int $organ = 0) {
        $this->prop_status = $prop_status;
        $this->status = $status;

        $this->organ = $organ;
        if ($organ)
            $this->operator = '=';
    }

    public function recommendations(): Collection {
        return Recommendation::query()->where('organ', $this->operator, $this->organ)
            ->where('status', '=', $this->status)
            ->orderBy('proposition_id')->get(['id', 'status', 'organ', 'comment', 'created_at']);
    }

    public function propositions(): Models {
        return $this->props(Proposition::query());
    }

    function physicals(): Collection {
        return $this->collections(IndividualApplication::query(), 'full_name');
    }

    function legals(): Collection {
        return $this->collections(LegalApplication::query(), 'legal_name');
    }

    public function applicant($physicals, $legals, &$p, &$l, $type): string {
        if ($type == 1)
            return $physicals[$p++];

        return $legals[$l++];
    }

    public function organs(): Collection {
        return Organ::query()->pluck('org_name', 'id');
    }

    private function collections(Builder $builder, string $attr): Collection {
        return $builder->where('organ', $this->operator, $this->organ)
            ->whereIn('status', $this->prop_status)->pluck($attr);
    }

    private function props(Builder $query): Models {
        return $query->where('organ', $this->operator, $this->organ)
            ->whereIn('status', $this->prop_status)
            ->get(['id', 'number', 'type']);
    }
}
