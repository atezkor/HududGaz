<?php

namespace App\ViewModels;

use App\Models\Designer;
use App\Models\Organ;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class ProjectViewModel extends ViewModel {

    private int $designerId;
    private array $statuses;

    public function __construct(int $designerId = 0, array $statuses = [Project::CREATED]) {
        $this->designerId = $designerId;
        $this->statuses = $statuses;
    }

    function projects(): Collection {
        return Project::with('proposition')
            ->whereIn('status', $this->statuses)
            ->when($this->designerId, fn(Builder $query) => $query->where('designer_id', $this->designerId))
            ->orderBy('proposition_id')
            ->get();
    }

    function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }

    public function designers(): Collection {
        if (!$this->designerId)
            return new Collection();

        return Designer::query()
            ->pluck('name', 'id');
    }

    function limit(): Collection|int { // TODO limit
        if (count($this->statuses))
            return limit(12, 10);
        return limitOne($this->statuses[0] + 9);
    }
}
