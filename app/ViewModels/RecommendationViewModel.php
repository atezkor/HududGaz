<?php

namespace App\ViewModels;

use App\Models\Individual;
use App\Models\Legal;
use App\Models\Proposition;
use App\Models\Region;
use App\Services\RecommendationService;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;


class RecommendationViewModel extends ViewModel {
    private RecommendationService $service;
    private array $status;
    private int $status_rec;
    private string $operator = '>';
    private int $organ;

    public function __construct(RecommendationService $service, int $organ = 0, array $status = [3], int $status_rec = 1) {
        $this->service = $service;
        $this->status = $status;
        $this->status_rec = $status_rec;

        $this->organ = $organ;
        if ($organ) {
            $this->operator = '=';
        }
    }

    public function recommendations(): Collection {
        return $this->service->filter($this->status_rec, $this->operator, $this->organ);
    }

    public function propositions(): \Illuminate\Database\Eloquent\Collection {
        return $this->service->propositions(Proposition::query(), $this->status, $this->operator, $this->organ);
    }

    function physicals(): Collection {
        return $this->filter(Individual::query(), 'full_name');
    }

    function legals(): Collection {
        return $this->filter(Legal::query(), 'legal_name');
    }

    public function applicant($physicals, $legals, &$p, &$l, $type): string {
        if ($type == 1) {
            return $physicals[$p ++];
        }

        return $legals[$l ++];
    }

    public function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    private function filter(Builder $builder, string $attr): Collection {
        return $builder->where('organ', $this->operator, $this->organ)
            ->whereIn('status', $this->status)->pluck($attr);
    }
}
