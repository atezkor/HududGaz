<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\TechCondition;
use App\Services\TechConditionService;
use App\Models\Recommendation;
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
        $equipments = json_decode($recommendation->getAttribute('equipments'));
        foreach ($equipments ?? [] as $equipment) {
            $equipment->equipment = $recommendation->equipment($equipment->equipment);
            $equipment->type = $recommendation->equipType($equipment->type);
        }

        return view("technic.control.$recommendation->type", ['recommendation' => $recommendation,
            'proposition' => $recommendation->proposition, 'method' => 'POST',
            'action' => route('technic.tech_condition.store', ['recommendation' => $recommendation]),
            'equipments' => $equipments]);
    }

    public function store(Request $request, Recommendation $recommendation): RedirectResponse {
        $data = $request['data'];
        $this->service->store($data, $recommendation);

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
}
