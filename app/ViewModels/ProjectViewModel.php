<?php

namespace App\ViewModels;

use App\Models\Designer;
use App\Models\Organ;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class ProjectViewModel extends ViewModel {

    private int $designerId;
    private array $statuses;

    private Collection $limits;

    public function __construct(int $designerId = 0, array $statuses = [Project::CREATED]) {
        $this->designerId = $designerId;
        $this->statuses = $statuses;

        $this->limits = Status::query()->pluck('term', 'id');
    }

    function projects(): Collection {
        return Project::with(['proposition', 'applicant:id,name,tin_pin'])
            ->whereIn('status', $this->statuses)
            ->when($this->designerId, fn(Builder $query) => $query->where('designer_id', $this->designerId))
            ->orderBy('proposition_id')
            ->get();
    }

    function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }

    public function designers(): Collection {
        if ($this->designerId)
            return new Collection();

        return Designer::query()
            ->pluck('name', 'id');
    }

    function limit(int $status): int {
        return $this->limits[$status + Proposition::PROJECT_FINISHED];
    }
}
