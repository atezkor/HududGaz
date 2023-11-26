<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as Models;
use App\Models\Proposition;
use App\Models\IndividualApplication;
use App\Models\LegalApplication;
use App\Models\Organ;
use Spatie\ViewModels\ViewModel;


class PropositionListViewModel extends ViewModel {

    private array $statuses;
    private string $operator = '>';
    private int $organ;

    public function __construct($statuses = [1, 2, 3], int $organ = 0) {
        $this->statuses = $statuses;
        $this->organ = $organ;
        if ($organ)
            $this->operator = '=';
    }

    function individuals(): Models {
        return $this->models(1);
    }

    function legalEntities(): Models {
        return $this->models(2);
    }

    function physicals(): Collection {
        return $this->collections(IndividualApplication::query(), 'stir');
    }

    function legals(): Collection {
        return $this->collections(LegalApplication::query(), 'legal_stir');
    }

    function organs(): Collection {
        return Organ::query()->pluck('org_name', 'id');
    }

    private function collections(Builder $builder, string $attribute): Collection {
        return $builder->where('organ', $this->operator, $this->organ)
            ->whereIn('status', $this->statuses)
            ->pluck($attribute);
    }

    private function models(int $type): Models {
        return Proposition::query()->where('organ', $this->operator, $this->organ)
            ->where('type', '=', $type)
            ->whereIn('status', $this->statuses)
            ->get();
    }
}
