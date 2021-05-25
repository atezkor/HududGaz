<?php

namespace App\ViewModels;

use App\Models\Individual;
use App\Models\Legal;
use App\Models\Proposition;
use App\Models\Region;
use App\Services\RecommendationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;


class RecommendationViewModel extends ViewModel {
    private RecommendationService $service;
    private array $status;
    private int $status_rec;

    public function __construct(RecommendationService $service, array $status = [3], int $status_rec = 1) {
        $this->service = $service;
        $this->status = $status;
        $this->status_rec = $status_rec;
    }

    public function models(): Collection {
        return $this->service->filter($this->status_rec);
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

    public function organs(): Collection {
        return Region::query()->get(['org_name']);
    }

    private function filter(Builder $builder, array $attr = ['*']): Collection {
        return $builder->whereIn('status', $this->status)->get($attr);
    }
}
