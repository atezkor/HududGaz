<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    public function organs(): View|RedirectResponse {
        try {
            $this->authorize('res_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.regions.index', [
            'models' => Region::all()
        ]);
    }

    public function designers(): View|RedirectResponse {
        try {
            $this->authorize('res_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.designers.index', [
            'models' => Designer::all()
        ]);
    }

    public function installers(): View|RedirectResponse {
        try {
            $this->authorize('res_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.mounters.index', [
            'models' => Mounter::all()
        ]);
    }

    public function propositions(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.propositions', new PropositionListViewModel());
    }

    public function recommendations(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.recommends', new RecommendationViewModel([4, 5], 2));
    }

    public function tech_conditions(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.index', new TechConditionViewModel());
    }

    public function projects(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('designer.archive', new ProjectViewModel([5]), [
            'designers' => Designer::query()->pluck('org_name', 'id')
        ]);
    }

    public function montages(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('installer.archive', new MontageViewModel([5]));
    }

    public function permits(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('engineer.permits', [
            'models' => Permit::all(),
            'districts' => districts()
        ]);
    }
}
