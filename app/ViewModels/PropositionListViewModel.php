<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as Models;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Legal;
use App\Models\Region;
use Spatie\ViewModels\ViewModel;

class PropositionListViewModel extends ViewModel {

    private array $status;
    private string $operator = '>';
    private int $organ;

    public function __construct($status = [1, 2, 3], int $organ = 0) {
        $this->status = $status;
        $this->organ = $organ;
        if ($organ) {
            $this->operator = '=';
        }
    }

    function individuals(): Models {
        return $this->models(1, $this->status, $this->operator ,$this->organ);
    }

    function legalEntities(): Models {
        return $this->models(2, $this->status, $this->operator, $this->organ);
    }

    function physicals(): Collection {
        return $this->collections(Individual::query(), 'stir');
    }

    function legals(): Collection {
        return $this->collections(Legal::query(), 'legal_stir');
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    private function collections(Builder $builder, string $attribute): Collection {
        return $builder->where('organ', $this->operator, $this->organ)
            ->whereIn('status', $this->status)
            ->pluck($attribute);
    }

    private function models(int $type, array $statuses, string $operator, int $organ): Models {
        return Proposition::query()->where('organ', $operator, $organ)
            ->where('type', '=', $type)
            ->whereIn('status', $statuses)
            ->get();
    }
}
