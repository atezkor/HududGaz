<?php

namespace App\ViewModels;

use App\Models\Application;
use App\Models\IndividualApplication;
use App\Models\LegalApplication;
use App\Models\Organ;
use App\Models\Proposition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as Models;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;


class PropositionListViewModel extends ViewModel {

    private array $statuses;
    private string $operator = '>';
    private int $organizationId;

    public function __construct($statuses = [1, 2, 3], int $organizationId = 0) {
        $this->statuses = $statuses;
        $this->organizationId = $organizationId;
        if ($organizationId)
            $this->operator = '=';
    }

    function organs(): Collection {
        return Organ::query()->pluck('name', 'id');
    }

    function individuals(): Models {
        return $this->models(Application::PHYSICAL);
    }

    function legalEntities(): Models {
        return $this->models(Application::LEGAL);
    }

    function physicals(): Collection {
        return $this->collections(IndividualApplication::query(), 'stir');
    }

    function legals(): Collection {
        return $this->collections(LegalApplication::query(), 'legal_stir');
    }

    private function collections(Builder $builder, string $attribute): Collection {
        return $builder->where('organ', $this->operator, $this->organizationId)
            ->whereIn('status', $this->statuses)
            ->pluck($attribute);
    }

    private function models(int $type): Models {
        return Proposition::query()->where('organ', $this->operator, $this->organizationId)
            ->where('type', '=', $type)
            ->whereIn('status', $this->statuses)
            ->get();
    }
}
