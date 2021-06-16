<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\Region;
use Spatie\ViewModels\ViewModel;

class ProjectViewModel extends ViewModel {
    private int $organ;
    private array $status;
    private array $prop_status;
    private string $statement = '>';

    public function __construct(array $status = [1], array $prop_status = [10], int $organ = 0) {
        $this->status = $status;
        $this->prop_status = $prop_status;
        $this->organ = $organ;

        if ($organ)
            $this->statement = '=';
    }

    function propositions(): Collection {
        return $this->models(Proposition::query(), $this->organ, $this->prop_status, ['organ', 'status', 'created_at']);
    }

    function projects(): Collection {
        return $this->models(Project::query(), $this->organ, $this->status, ['id', 'applicant', 'condition', 'comment'], 'proposition_id');
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    private function models(Builder $builder, int $organ, array $status, array $attributes, string $order = 'id'): Collection {
        return $builder->where('organ', $this->statement, $organ)
            ->whereIn('status', $status)
            ->orderBy($order)->get($attributes);
    }
}
