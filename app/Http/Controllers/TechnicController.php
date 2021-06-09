<?php

namespace App\Http\Controllers;

use App\Models\TechCondition;
use App\Services\TechConditionService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Services\RecommendationService;
use App\ViewModels\RecommendationViewModel;

class TechnicController extends Controller {

    private TechConditionService $service;
    private RecommendationService $rec_service;

    public function __construct(TechConditionService $service, RecommendationService $rec_service) {
        $this->service = $service;
        $this->rec_service = $rec_service;
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

    public function edit() {

    }

    public function update() {

    }

    public function back(Request $request, Recommendation $recommendation) {
        $this->rec_service->back($recommendation, $request['comment']);
    }

    public function index(): View {
        $tech_conditions = TechCondition::all();
        return view('technic.index', ['models' => $tech_conditions]);
    }
}
