<?php

namespace App\ViewModels;

use App\Models\Region;
use App\Services\PropositionService;
use Illuminate\Database\Eloquent\Builder;
use Spatie\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Individual;
use App\Models\Legal;

class PropositionListViewModel extends ViewModel {

    private \Illuminate\Support\Collection $organs;
    private PropositionService $service;
    private array $statuses;
    public function __construct(PropositionService $service, $statuses = [1, 2, 3]) {
        $this->organs = Region::query()->pluck('org_name', 'id');
        $this->service = $service;
        $this->statuses = $statuses;
    }

    function individuals(): Collection {
        return $this->service->filter(1, $this->statuses);
    }

    function legalEntities(): Collection {
        return $this->service->filter(2, $this->statuses);
    }

    function physicals(): Collection {
        return $this->filter(Individual::query(), ['stir']);
    }

    function legals(): Collection {
        return $this->filter(Legal::query(), ['legal_stir']);
    }

    function organ($organ): string {
        return $this->organs[$organ];
    }

    private function filter(Builder $builder, array $attributes = ['*']): Collection {
        return $builder->whereIn('status', $this->statuses)
            ->get($attributes);
    }
}
