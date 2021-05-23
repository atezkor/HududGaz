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
    private int $status;

    public function __construct(RecommendationService $service, $status = 3) {
        $this->service = $service;
        $this->status = $status;
    }

    public function models(): Collection {
        return $this->service->filter($this->status - 2);
    }

    public function propositions(): Collection {
        return $this->service->propositions(Proposition::query(), $this->status);
    }

    function physicals(): Collection {
        return $this->filter(Individual::query(), ['full_name']);
    }

    function legals(): Collection {
        return $this->filter(Legal::query(), ['leader']);
    }

    public function applicant($physicals, $legals, &$p, &$l, $type): string {
        if ($type == 1) {
            return $physicals[$p ++]->full_name;
        }

        return $legals[$l ++]->leader;
    }

    private function filter(Builder $builder, array $attr = ['*']): Collection {
        return $builder->where('status', '=', $this->status)->get($attr);
    }
}
