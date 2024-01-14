<?php

namespace App\ViewModels;

use App\Models\{Application, Organ, Proposition, Recommendation, Status};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Models;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class RecommendationViewModel extends ViewModel {

    private array $propStatuses;
    private array $statuses;
    private int $organizationId;

    private Collection $limits;

    public function __construct(array $propStatuses = [Proposition::ACCEPTED], array $statuses = [Recommendation::CREATED], int $organizationId = 0) {
        $this->propStatuses = $propStatuses;
        $this->statuses = $statuses;

        $this->organizationId = $organizationId;
        $this->limits = Status::query()->pluck('term', 'id');
    }

    public function recommendations(): Collection {
        return Recommendation::query()
            ->with(['proposition:id,number', 'applicant', 'organ:id,name'])
            ->whereIn('status', $this->statuses)
            ->when($this->organizationId, fn(Builder $query) => $query->where('organization_id', $this->organizationId))
            ->orderBy('proposition_id')
            ->get(['id', 'proposition_id', 'applicant_id', 'status', 'organization_id', 'comment', 'created_at']);
    }

    public function propositions(): Models {
        return Proposition::query()
            ->with('recommendation')
            ->whereIn('status', $this->propStatuses)
            ->when($this->organizationId, fn(Builder $query) => $query->where('organization_id', $this->organizationId))
            ->get(['id', 'number', 'type', 'created_at']);
    }

    public function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }

    function limit(int $status): int {
        return $this->limits[$status + Proposition::PROJECT_FINISHED];
    }

    /* Reference and pointer function */
    public function applicant($physicals, $legals, &$p, &$l, $type): string {
        // @php($l = 0)
        // @php($p = 0)
        // applicant($physicals, $legals, $p, $l, 1|2)
        if ($type == Application::PHYSICAL)
            return $physicals[$p++];

        return $legals[$l++];
    }
}
