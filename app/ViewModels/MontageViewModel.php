<?php

namespace App\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;
use App\Models\{
    Montage, Organ
};

class MontageViewModel extends ViewModel {

    private array $status;
    private int $firm;
    private string $statement = '>';

    public function __construct(array $status = [Montage::CREATED], $user = null) {
        $this->status = $status;
        $this->firm = $user->organ ?? 0;

        if ($this->firm)
            $this->statement = '=';
    }

    function models(): Collection {
        return $this->collections(Montage::query(), $this->status);
    }

    function organs(): Collection {
        return Organ::query()->pluck('org_name', 'id');
    }

    function limit(): Collection|int {
        if (count($this->status) > 1)
            return limit(17, 15);
        return limitOne(15);
    }

    private function collections(Builder $query, $status): Collection {
        return $query->where('mounter_id', $this->statement, $this->firm)
            ->whereIn('status', $status)->get();
    }
}
