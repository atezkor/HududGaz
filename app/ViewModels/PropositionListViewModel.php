<?php

namespace App\ViewModels;

use App\Models\Region;
use App\Services\PropositionService;
use Spatie\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Individual;
use App\Models\Legal;

class PropositionListViewModel extends ViewModel {

    private Collection $organs;
    private PropositionService $service;
    private array $statuses;
    public function __construct(PropositionService $service, $statuses = [1, 2, 3]) {
        $this->organs = Region::query()->get(['id', 'org_name']);
        $this->service = $service;
        $this->statuses = $statuses;
    }

    function individuals(): Collection {
        return $this->service->filter(1, $this->statuses);
    }

    function physicals(): Collection {
        return Individual::all();
    }

    function legalEntities(): Collection {
        return $this->service->filter(2, $this->statuses);
    }

    function legals(): Collection {
        return Legal::all();
    }

    function organ($organ): string {
        return $this->organs[$organ]->org_name;
    }
}
