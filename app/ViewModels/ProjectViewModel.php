<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\TechCondition;
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

    function conditions(): Collection {
        return $this->filter(TechCondition::query(), 2);
    }

    function projects(): Collection {
        return $this->models(Project::query(), auth()->user()->organ ?? 0, $this->status, ['id', 'applicant'], 'proposition_id');
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    private function filter(Builder $query, int $status = 1): Collection {
        return $query->where('status', $status)->orderBy('proposition_id')->pluck('id');
    }

    private function models(Builder $builder, int $organ, int $status, array $attributes, $order = 'id'): Collection {
        return $builder->where('organ', $organ)
            ->where('status', $status)
            ->orderBy($order)->get($attributes);
    }
}
