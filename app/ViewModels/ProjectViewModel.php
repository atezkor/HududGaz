<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;
use App\Models\Project;
use App\Models\Region;


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
        return Project::with('applicant')
            ->where('designer_id', $this->statement, $this->designer)
            ->whereIn('status', $this->status)
            ->orderBy('proposition_id')->get();
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    function limit(): Collection|int {
        if (count($this->status) > 1)
            return limit(12, 10);
        return limitOne($this->status[0] + 9);
    }
}
