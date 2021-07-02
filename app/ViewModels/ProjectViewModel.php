<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Region;
use Spatie\ViewModels\ViewModel;

class ProjectViewModel extends ViewModel {
    private int $designer;
    private array $status;
    private string $statement = '>';

    public function __construct(array $status = [1], int $designer = 0) {
        $this->status = $status;
        $this->designer = $designer;

        if ($designer)
            $this->statement = '=';
    }

    function projects(): Collection {
        return $this->models(Project::query(), ['id', 'applicant', 'condition',
            'organ', 'comment', 'designer', 'status', 'created_at']);
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    function limit(): Collection|int {
        if (count($this->status) > 1)
            return limit(12, 10);
        return limitOne($this->status[0] + 9);
    }

    private function models(Builder $builder, array $attributes = []): Collection {
        return $builder->where('designer', $this->statement, $this->designer)
            ->whereIn('status', $this->status)
            ->orderBy('proposition_id')->get($attributes);
    }
}
