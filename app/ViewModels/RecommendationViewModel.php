<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Recommendation;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Legal;
use App\Models\Region;
use Spatie\ViewModels\ViewModel;


class RecommendationViewModel extends ViewModel {
    private array $status;
    private int $status_rec;
    private string $operator = '>';
    private int $organ;

    public function __construct(int $organ = 0, array $status = [3], int $status_rec = 1) {
        $this->status = $status;
        $this->status_rec = $status_rec;

        $this->organ = $organ;
        if ($organ) {
            $this->operator = '=';
        }
    }

    public function recommendations(): Collection {
        return $this->models($this->status_rec, $this->operator, $this->organ);
    }

    public function propositions(): \Illuminate\Database\Eloquent\Collection {
        return $this->props(Proposition::query(), $this->status, $this->operator, $this->organ);
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
            ->whereIn('status', $this->status)->pluck($attr);
    }

    private function models(int $status, string $operator, int $organ): Collection {
        $add = request()->route()->getName() == "district.recommendations.cancelled";
        $models = Recommendation::query()->where('organ', $operator, $organ)
            ->where('status', '=', $status)
            ->orderBy('proposition_id');
        return $add ? $models->get(['id', 'comment']) : $models->pluck('id');
    }

    private function props(Builder $query, array $status, string $operator, int $organ): \Illuminate\Database\Eloquent\Collection {
        return $query->where('organ', $operator, $organ)
            ->whereIn('status', $status)
            ->get(['id', 'number', 'type', 'status', 'organ', 'created_at']);
    }
}
