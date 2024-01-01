<?php

namespace App\ViewModels;

use App\Models\Designer;
use App\Models\Organ;
use App\Models\Project;
use App\Models\Status;
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
            return $this->limitMany(12, 10);
        return $this->limitOne($this->statuses[0] + 9); // TODO statuses
    }

    function limitMany(int $status, int $offset = 0): Collection {
        return Status::query()->offset($offset)
            ->limit($status - $offset)
            ->pluck('term', 'id');
    }

    function limitOne(int $status): int {
        return Status::query()->find($status)->getAttribute('term');
    }
}
