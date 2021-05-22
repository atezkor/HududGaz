<?php

namespace App\ViewModels;

use App\Models\Individual;
use App\Models\Legal;
use App\Models\Proposition;
use App\Services\RecommendationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class RecommendationViewModel extends ViewModel {
    private RecommendationService $service;

    public function __construct(RecommendationService $service) {
        $this->service = $service;
    }

    public function models(): Collection {
        return $this->service->filter(1);
    }

    function individuals(): Collection {
        return $this->service->propositions(Proposition::query(), 1, [3]);
    }

    function legalEntities(): Collection {
        return $this->service->propositions(Proposition::query(), 2, [3]);
    }

    function physicals(): Collection {
        return $this->filter(Individual::query());
    }

    function legals(): Collection {
        return $this->filter(Legal::query());
    }

    private function filter(Builder $builder): Collection {
        return $builder->whereIn('status', [3])->get();
    }
}
