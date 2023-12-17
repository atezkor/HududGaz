<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Models\TechCondition;
use App\Models\Recommendation;
use App\Services\TechConditionService;
use App\Services\RecommendationService;
use App\ViewModels\RecommendationViewModel;
use App\Models\Activity;
use App\Models\Proposition;
use App\Models\Organ;
use App\Models\Status;
use App\ViewModels\TechConditionViewModel;


class TechnicController extends Controller {
    use ValidatesRequests;

    private TechConditionService $service;
    private RecommendationService $rec_service;

    public function __construct(TechConditionService $service, RecommendationService $rec_service) {
        $this->service = $service;
        $this->rec_service = $rec_service;
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.index', new TechConditionViewModel());
    }

    public function recommendations(): View|RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.recommends', new RecommendationViewModel([4, 5], 2));
    }

    public function show(Recommendation $recommendation): RedirectResponse {
        $url = $this->rec_service->techShow($recommendation);
        return redirect("$url");
    }

    public function create(Recommendation $recommendation): View|RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $equipments = $recommendation->getEquipments();
        return view("technic.control.$recommendation->type", [
            'recommendation' => $recommendation,
            'proposition' => $recommendation->proposition,
            'equipments' => $equipments,
            'action' => route('technic.tech_condition.store', ['recommendation' => $recommendation])
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, Recommendation $recommendation): RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $this->validate($request, [
            'description' => [],
            'data' => ['required']
        ], [], [
            'data' => __('technic.tech_condition.ref')
        ]);
        $this->service->create($data, $recommendation);

        return redirect()->route('technic.index');
    }

    public function show_condition(TechCondition $condition): RedirectResponse {
        return redirect($this->service->get($condition));
    }

    public function back(Request $request, Recommendation $recommendation): RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->rec_service->back($recommendation, $request['comment']);
        return redirect()->back();
    }

    public function edit(TechCondition $condition): View|RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $recommendation = $condition->proposition->recommendation;
        $equipments = $recommendation->getEquipments();
        return view("technic.control.$recommendation->type", [
            'recommendation' => $recommendation,
            'proposition' => $recommendation->proposition,
            'equipments' => $equipments,
            'action' => route('technic.tech_condition.update', ['condition' => $condition])
        ]);
    }

    /**
     * @param Request $request
     * @param TechCondition $condition
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, TechCondition $condition): RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $this->validate($request, [
            'description' => [],
            'data' => ['required']
        ], [], [
            'data' => __('technic.tech_condition.ref')
        ]);
        $this->service->update($data, $condition);
        return redirect()->route('technic.index');
    }

    public function upload(Request $request, TechCondition $condition): RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->upload($request, $condition);
        return redirect()->route('technic.index');
    }

    /* Reports */
    public function region(): View|RedirectResponse {
        try {
            $this->authorize('show_report');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.reports.region', [
            'models' => Organ::query()->get(['id', 'org_name', 'region']),
            'activities' => Activity::query()->pluck('activity', 'id'),
            'propositions' => Proposition::query()->get(['organ', 'activity_type'])->groupBy('activity_type')
        ]);
    }

    public function organ(): View|RedirectResponse {
        try {
            $this->authorize('show_report');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.reports.organ', [
            'models' => Organ::query()->pluck('org_name', 'id'),
            'activities' => Activity::query()->pluck('activity', 'id'),
            'propositions' => Proposition::query()->get(['organ', 'activity_type'])->groupBy('organ')
        ]);
    }

    public function more(): View|RedirectResponse {
        try {
            $this->authorize('show_report');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.reports.more', [
            'models' => Status::query()->pluck('description', 'id'),
            'activities' => Activity::query()->pluck('activity', 'id'),
            'propositions' => Proposition::query()->get(['status', 'activity_type'])->groupBy('status')
        ]);
    }
}
