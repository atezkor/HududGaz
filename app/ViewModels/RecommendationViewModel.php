<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Models;
use App\Models\Recommendation;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Legal;
use App\Models\Region;
use Spatie\ViewModels\ViewModel;


class RecommendationViewModel extends ViewModel {
    private array $prop_status;
    private int $status;
    private int $organ;
    private string $operator = '>';

    public function __construct(array $prop_status = [3], int $status = 1, int $organ = 0) {
        $this->prop_status = $prop_status;
        $this->status = $status;

        $this->organ = $organ;
        if ($organ) {
            $this->operator = '=';
        }
    }

    public function recommendations(): Collection {
        return $this->models($this->status, $this->operator, $this->organ);
    }

    public function propositions(): Models {
        return $this->props(Proposition::query(), $this->prop_status, $this->operator, $this->organ);
    }

    function physicals(): Collection {
        return $this->collections(Individual::query(), 'full_name');
    }

    function legals(): Collection {
        return $this->collections(Legal::query(), 'legal_name');
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

    private function collections(Builder $builder, string $attr): Collection {
        return $builder->where('organ', $this->operator, $this->organ)
            ->whereIn('status', $this->prop_status)->pluck($attr);
    }

    private function models(int $status, string $operator, int $organ): Collection {
        $add = request()->route()->getName() == "district.recommendations.cancelled";
        $models = Recommendation::query()->where('organ', $operator, $organ)
            ->where('status', '=', $status)
            ->orderBy('proposition_id');
        return $add ? $models->get(['id', 'comment']) : $models->pluck('id');
    }

    private function props(Builder $query, array $status, string $operator, int $organ): Models {
        return $query->where('organ', $operator, $organ)
            ->whereIn('status', $status)
            ->get(['id', 'number', 'type', 'status', 'organ', 'created_at']);
    }
}
