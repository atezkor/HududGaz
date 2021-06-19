<?php

namespace App\ViewModels;

use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\Montage;
use Spatie\ViewModels\ViewModel;

class MontageViewModel extends ViewModel {

    private array $status;
    private int $firm;
    private string $statement = '>';

    public function __construct(array $status = [1], $user = null) {
        $this->status = $status;
        $this->firm = $user->organ ?? 0;

        if ($this->firm)
            $this->statement = '=';
    }

    function models(): Collection {
        return $this->collections(Montage::query());
    }

    function organs(): Collection {
        return Region::query()->pluck('org_name', 'id');
    }

    function limit(): Collection|int {
        if (count($this->status) > 1)
            return limit(17, 15);
        return limitOne(15);
    }

    private function collections(Builder $query): Collection {
        return $query->where('firm', $this->statement, $this->firm)
            ->whereIn('status', $this->status)->get();
    }
}
