<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Designer;
use App\Models\Mounter;
use App\Models\Permit;
use App\Models\Region;
use App\Models\Proposition;
use App\ViewModels\MontageViewModel;
use App\ViewModels\ProjectViewModel;
use App\ViewModels\PropositionListViewModel;
use App\ViewModels\RecommendationViewModel;
use App\ViewModels\TechConditionViewModel;

class DirectorController extends Controller {

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = Proposition::query()->select(
            "id" ,
            DB::raw("(count(id)) as count"),
            DB::raw("(DATE_FORMAT(created_at, '%m')) as month")
        )->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->get();

        $data = [];
        $j = 0;
        $count = $models->count();
        for ($i = 1; $i <= 12; $i ++) {
            if ($j < $count) {
                if ((int) $models[$j]->month == $i) {
                    $data[$i] = $models[$j]->count;
                    $j ++;
                    continue;
                }
            }

            $data[$i] = 0;
        }
        unset($models);

        return view('director.index', [
            'models' => $data,
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
            'show' => false
        ]);
    }

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
