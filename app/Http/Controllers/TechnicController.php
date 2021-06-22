<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Proposition;
use App\Models\Region;
use App\Models\Status;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Models\TechCondition;
use App\Models\Recommendation;
use App\Services\TechConditionService;
use App\Services\RecommendationService;
use App\ViewModels\RecommendationViewModel;
use App\ViewModels\TechConditionViewModel;

class TechnicController extends Controller {

    private TechConditionService $service;
    private RecommendationService $rec_service;

    public function __construct(TechConditionService $service, RecommendationService $rec_service) {
        $this->service = $service;
        $this->rec_service = $rec_service;
    }

    public function index(): View {
        return view('technic.index', new TechConditionViewModel());
    }

    public function recommendations(): View {
        return view('technic.recommends', new RecommendationViewModel($this->rec_service, 0, [4, 5], 2));
    }

    public function show(Recommendation $recommendation): RedirectResponse {
        return $this->rec_service->techShow($recommendation);
    }

    public function create(Recommendation $recommendation): View {
        $equipments = $recommendation->getEquipments();
        return view("technic.control.$recommendation->type", [
            'recommendation' => $recommendation,
            'proposition' => $recommendation->proposition,
            'equipments' => $equipments,
            'method' => 'POST',
            'action' => route('technic.tech_condition.store', ['recommendation' => $recommendation])
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, Recommendation $recommendation): RedirectResponse {
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
        return redirect($this->service->show($condition));
    }

    public function back(Request $request, Recommendation $recommendation) {
        $this->rec_service->back($recommendation, $request['comment']);
    }

    public function upload(Request $request, TechCondition $condition): RedirectResponse {
        $this->service->upload($request, $condition);
        return redirect()->route('technic.index');
    }

    public function region(): View {
        return view('technic.reports.region', [
            'models' => Status::query()->pluck('description', 'id'),
            'activities' => Activity::query()->pluck('activity', 'id'),
            'propositions' => Proposition::query()->get(['status', 'activity_type'])->groupBy('status')
        ]);
    }

    public function organ(): View {
        return view('technic.reports.organ', [
            'models' => Region::query()->pluck('org_name', 'id'),
            'activities' => Activity::query()->pluck('activity', 'id'),
            'propositions' => Proposition::query()->get(['organ', 'activity_type'])->groupBy('organ')
        ]);
    }

    public function more(): View {
        return view('technic.reports.more');
    }
}
