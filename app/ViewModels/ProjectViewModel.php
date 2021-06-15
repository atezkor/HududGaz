<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\Region;
use Spatie\ViewModels\ViewModel;

class ProjectViewModel extends ViewModel {
    private int $prop_status;
    private int $status;

    public function __construct(int $status = 1, int $prop_status = 10) {
        $this->status = $status;
        $this->prop_status = $prop_status;
    }

    function propositions(): Collection {
        return $this->models(Proposition::query(), auth()->user()->organ ?? 0, $this->prop_status, ['organ', 'status', 'created_at']);
    }

    function projects(): Collection {
        return $this->models(Project::query(), auth()->user()->organ ?? 0, $this->status, ['id', 'applicant', 'condition'], 'proposition_id');
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    private function models(Builder $builder, int $organ, int $status, array $attributes, $order = 'id'): Collection {
        return $builder->where('organ', $organ)
            ->where('status', $status)
            ->orderBy($order)->get($attributes);
    }
}
