<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Organ;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Models\Status;
use App\Models\TechCondition;
use App\Services\RecommendationService;
use App\Services\TechConditionService;
use App\ViewModels\TechConditionViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class TechnicConditionController extends Controller {
    use ValidatesRequests;

    private TechConditionService $service;
    private RecommendationService $recService;

    public function __construct(TechConditionService $service, RecommendationService $recService) {
        $this->service = $service;
        $this->recService = $recService;
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.index', new TechConditionViewModel());
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

    public function show(Recommendation $recommendation): RedirectResponse {
        $url = $this->recService->review($recommendation);
        return redirect($url);
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

        $this->recService->back($recommendation, $request['comment']);
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

        $organs = Organ::query()
            ->with('district')
            ->get(['id', 'name']);

        $propositions = Proposition::query()
            ->get(['organization_id', 'activity_type_id'])
            ->groupBy('activity_type_id');

        $activityTypes = Activity::query()->pluck('activity', 'id');

        return view('technic.reports.region', [
            'models' => $organs,
            'activities' => $activityTypes,
            'propositions' => $propositions
        ]);
    }

    public function organ(): View|RedirectResponse {
        try {
            $this->authorize('show_report');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = Organ::query()->pluck('name', 'id');
        $activityTypes = Activity::query()->pluck('activity', 'id');
        $propositions = Proposition::query()
            ->get(['organization_id', 'activity_type_id'])
            ->groupBy('organization_id');

        return view('technic.reports.organ', [
            'models' => $models,
            'activities' => $activityTypes,
            'propositions' => $propositions
        ]);
    }

    public function detail(): View|RedirectResponse {
        try {
            $this->authorize('show_report');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $statuses = Status::query()->pluck('description', 'id');
        $activities = Activity::query()->pluck('activity', 'id');
        $propositions = Proposition::query()
            ->get(['status', 'activity_type_id'])
            ->groupBy('status');

        return view('technic.reports.more', [
            'models' => $statuses,
            'activities' => $activities,
            'propositions' => $propositions
        ]);
    }
}
