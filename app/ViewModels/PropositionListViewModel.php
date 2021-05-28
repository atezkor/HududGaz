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
    public function __construct(PropositionService $service, $statuses = [1, 2, 3]) {
        $this->service = $service;
        $this->statuses = $statuses;
    }

    function individuals(): \Illuminate\Database\Eloquent\Collection {
        return $this->service->filter(1, $this->statuses);
    }

    function legalEntities(): \Illuminate\Database\Eloquent\Collection {
        return $this->service->filter(2, $this->statuses);
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
        return $builder->whereIn('status', $this->statuses)
            ->pluck($attribute);
    }
}
