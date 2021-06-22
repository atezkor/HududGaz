<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Designer;
use App\Models\Mounter;
use App\Models\Permit;
use App\Models\Region;
use App\ViewModels\MontageViewModel;
use App\ViewModels\ProjectViewModel;
use App\ViewModels\PropositionListViewModel;
use App\ViewModels\RecommendationViewModel;
use App\ViewModels\TechConditionViewModel;

class DirectorController extends Controller {

    public function organs(): View {
        return view('admin.regions.index', [
            'models' => Region::all()
        ]);
    }

    public function designers(): View {
        return view('admin.designers.index', [
            'models' => Designer::all()
        ]);
    }

    public function installers(): View {
        return view('admin.mounters.index', [
            'models' => Mounter::all()
        ]);
    }

    public function propositions(): View {
        return view('technic.propositions', new PropositionListViewModel());
    }

    public function recommendations(): View {
        return view('technic.recommends', new RecommendationViewModel());
    }

    public function tech_conditions(): View {
        return view('technic.index', new TechConditionViewModel());
    }

    public function projects(): View {
        return view('engineer.projects', new ProjectViewModel([5]));
    }

    public function montages(): View {
        return view('engineer.montages', new MontageViewModel([5]));
    }

    public function permits(): View {
        return view('engineer.permits', [
            'models' => Permit::all()
        ]);
    }
}
