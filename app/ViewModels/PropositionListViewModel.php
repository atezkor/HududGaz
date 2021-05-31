<?php

namespace App\ViewModels;

use App\Models\Region;
use App\Services\PropositionService;
use Illuminate\Database\Eloquent\Builder;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;
use App\Models\Individual;
use App\Models\Legal;

class PropositionListViewModel extends ViewModel {

    private PropositionService $service;
    private array $statuses;
    private string $operator = '>';
    private int $organ;

    public function __construct(PropositionService $service, $statuses = [1, 2, 3], int $organ = 0) {
        $this->service = $service;
        $this->statuses = $statuses;
        $this->organ = $organ;
        if ($organ) {
            $this->operator = '=';
        }
    }

    function individuals(): \Illuminate\Database\Eloquent\Collection {
        return $this->service->filter(1, $this->statuses, $this->operator ,$this->organ);
    }

    function legalEntities(): \Illuminate\Database\Eloquent\Collection {
        return $this->service->filter(2, $this->statuses, $this->operator, $this->organ);
    }

    function physicals(): Collection {
        return $this->filter(Individual::query(), 'stir');
    }

    function legals(): Collection {
        return $this->filter(Legal::query(), 'legal_stir');
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    private function filter(Builder $builder, string $attribute): Collection {
        return $builder->where('organ', $this->operator, $this->organ)
            ->whereIn('status', $this->statuses)
            ->pluck($attribute);
    }
}
