<?php

namespace App\ViewModels;

use App\Models\{Montage, Mounter, Organ};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class MontageViewModel extends ViewModel {

    private array $statuses;
    private int $firmId;

    public function __construct(array $statuses = [Montage::CREATED], $organizationId = 0) {
        $this->statuses = $statuses;
        $this->firmId = $organizationId;
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
        if (!$this->firmId)
            return new Collection();

        return Mounter::query()
            ->pluck('short_name', 'id');
    }

    function limit(): Collection|int {
        if (count($this->statuses) > 1)
            return limit(17, 15);
        return limitOne(15);
    }
}
