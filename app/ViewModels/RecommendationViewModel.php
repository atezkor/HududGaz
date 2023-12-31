<?php

namespace App\ViewModels;

use App\Models\{Application, Organ, Proposition, Recommendation};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Models;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class RecommendationViewModel extends ViewModel {

    private array $propStatuses;
    private int $status;
    private int $organizationId;

    public function __construct(array $propStatuses = [Proposition::ACCEPTED], int $status = Recommendation::CREATED, int $organizationId = 0) {
        $this->propStatuses = $propStatuses;
        $this->status = $status;

        $this->organizationId = $organizationId;
    }

    public function recommendations(): Collection {
        return Recommendation::query()
            ->with(['proposition:id,number', 'applicant', 'organ:id,name'])
            ->where('status', $this->status)
            ->when($this->organizationId, fn(Builder $query) => $query->where('organization_id', $this->organizationId))
            ->orderBy('proposition_id')
            ->get(['id', 'proposition_id', 'applicant_id', 'status', 'organization_id', 'comment', 'created_at']);
    }

    public function propositions(): Models {
        return Proposition::query()
            ->with('recommendation')
            ->whereIn('status', $this->propStatuses)
            ->when($this->organizationId, fn(Builder $query) => $query->where('organization_id', $this->organizationId))
            ->get(['id', 'number', 'type']);
    }

    public function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }

    /* Reference and pointer function */
    public function applicant($physicals, $legals, &$p, &$l, $type): string {
        // @php($l = 0)
        // @php($p = 0)
        if ($type == Application::PHYSICAL)
            return $physicals[$p++];

        return $legals[$l++];
    }
}
