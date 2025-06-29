<?php

namespace App\ViewModels;

use App\Models\{Montage, Mounter, Organ, Proposition, Status};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class MontageViewModel extends ViewModel {

    private array $statuses;
    private int $firmId;

    private Collection $limits;

    public function __construct(array $statuses = [Montage::CREATED], $organizationId = 0) {
        $this->statuses = $statuses;
        $this->firmId = $organizationId;
        $this->limits = Status::query()->pluck('term', 'id');
    }

    function models(): Collection {
        return Montage::query()
            ->whereIn('status', $this->statuses)
            ->when($this->firmId, fn(Builder $query) => $query->where('mounter_id', $this->firmId))
            ->get();
    }

    function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }

    public function mounters(): Collection {
        if ($this->firmId)
            return new Collection();

        return Mounter::query()
            ->pluck('short_name', 'id');
    }

    /* This is function for application term */
    // int $status, int $offset = 0
    function limit(int $status): int {
        return $this->limits[$status + Proposition::PROJECT_FINISHED];
    }
}
