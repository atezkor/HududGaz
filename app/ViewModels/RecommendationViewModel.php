<?php

namespace App\ViewModels;

use App\Models\{LegalApplicant, Organ, PhysicalApplicant, Proposition, Recommendation};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Models;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class RecommendationViewModel extends ViewModel {

    private array $propStatuses;
    private int $status;
    private int $organizationId;

    public function __construct(array $propStatuses = [Proposition::CREATED_B], int $status = Recommendation::CREATED, int $organizationId = 0) {
        $this->propStatuses = $propStatuses;
        $this->status = $status;

        $this->organizationId = $organizationId;
    }

    public function recommendations(): Collection {
        return Recommendation::query()
            ->where('status', '=', $this->status)
            ->when($this->organizationId, fn(Builder $query) => $query->where('organization_id', $this->organizationId))
            ->orderBy('proposition_id')
            ->get(['id', 'status', 'organization_id', 'comment', 'created_at']);
    }

    public function propositions(): Models {
        return Proposition::query()
            ->whereIn('status', $this->propStatuses)
            ->when($this->organizationId, fn(Builder $query) => $query->where('organization_id', $this->organizationId))
            ->get(['id', 'number', 'type']);
    }

//    function physicals(): Collection {
//        return PhysicalApplicant::query()->pluck('name');
//    }
//
//    function legals(): Collection {
//        return LegalApplicant::query()->pluck('name');
//    }

    public function applicant($physicals, $legals, &$p, &$l, $type): string {
        if ($type == 1)
            return $physicals[$p++];

        return $legals[$l++];
    }

    public function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }
}
