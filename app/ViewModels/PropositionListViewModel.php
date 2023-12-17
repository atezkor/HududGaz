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

    public function __construct($statuses = [Proposition::CREATED], int $organizationId = 0) {
        $this->statuses = $statuses;
        $this->organizationId = $organizationId;
    }

    function applications(): Models {
        return Proposition::query()
            ->with('individual')
            ->when($this->organizationId, function(Builder $query) {
                return $query->where('organization_id', $this->organizationId);
            })
            ->where('type', Application::PHYSICAL)
            ->whereIn('status', $this->statuses)
            ->get();
    }

    function propositions(): Models {
        return Proposition::query()
            ->with('legal')
            ->when($this->organizationId, function(Builder $query) {
                return $query->where('organization_id', $this->organizationId);
            })
            ->where('type', Application::LEGAL)
            ->whereIn('status', $this->statuses)
            ->get();
    }

    function limit(): Collection {
        return self::limiter(Proposition::CREATED_T);
    }

    /* This is function for application term */
    private static function limiter(int $status, int $offset = 0): Collection {
        return Status::query()
            ->offset($offset)
            ->limit($status - $offset)
            ->pluck('term', 'id');
    }
}
