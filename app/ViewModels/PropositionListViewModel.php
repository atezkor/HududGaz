<?php

namespace App\ViewModels;

use App\Models\Application;
use App\Models\Proposition;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Models;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class PropositionListViewModel extends ViewModel {

    private array $statuses;
    private int $organizationId;

    private Collection $limits;

    public function __construct($statuses = [Proposition::CREATED, Proposition::REVIEWED], int $organizationId = 0) {
        $this->statuses = $statuses;
        $this->organizationId = $organizationId;

        $this->limits = Status::query()->pluck('term', 'id');
    }

    function applications(): Models {
        return Proposition::query()
            ->with(['applicant', 'organ:id,name'])
            ->when($this->organizationId, function(Builder $query) {
                return $query->where('organization_id', $this->organizationId);
            })
            ->where('type', Application::PHYSICAL)
            ->whereIn('status', $this->statuses)
            ->get();
    }

    function propositions(): Models {
        return Proposition::query()
            ->with(['applicant', 'organ:id,name'])
            ->when($this->organizationId, function(Builder $query) {
                return $query->where('organization_id', $this->organizationId);
            })
            ->where('type', Application::LEGAL)
            ->whereIn('status', $this->statuses)
            ->get();
    }

    /* This is function for application term */
    function limit(int $status): int {
        return $this->limits[$status + Proposition::PROJECT_FINISHED];
    }
}
