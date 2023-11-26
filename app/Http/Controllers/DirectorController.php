<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Designer;
use App\Models\License;
use App\Models\Montage;
use App\Models\Mounter;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\Organ;
use App\Models\User;
use App\Services\DirectorService;
use App\ViewModels\MontageViewModel;
use App\ViewModels\ProjectViewModel;
use App\ViewModels\PropositionListViewModel;
use App\ViewModels\RecommendationViewModel;
use App\ViewModels\TechConditionViewModel;


class DirectorController extends Controller {

    private DirectorService $service;

    public function __construct(DirectorService $service) {
        $this->service = $service;
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('director.index', [
            'models' => $this->service->propositions(),
        ]);
    }

    public function users(): View|RedirectResponse {
        try {
            $this->authorize('res_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.users.index', [
            'models' => User::all(),
            'branch' => getName()
        ]);
    }

    public function organs(): View|RedirectResponse {
        try {
            $this->authorize('res_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.regions.index', [
            'models' => Organ::all()
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

        return view('technic.recommends', new RecommendationViewModel([Proposition::IN_PROCESS, Proposition::COMPLETED], 2));
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

        return view('designer.archive', new ProjectViewModel([Project::COMPLETED]), [
            'designers' => Designer::query()->pluck('org_name', 'id')
        ]);
    }

    public function montages(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('installer.archive', new MontageViewModel([Montage::COMPLETED]));
    }

    public function permits(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('engineer.permits', [
            'models' => License::all(),
            'districts' => districts()
        ]);
    }
}
