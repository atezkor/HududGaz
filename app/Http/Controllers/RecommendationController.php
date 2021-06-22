<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use App\Models\Recommendation;
use App\Models\CancelledProposition;
use App\Models\Proposition;
use App\Models\Equipment;
use App\Services\RecommendationService;
use App\Services\PropositionService;
use App\Http\Requests\RecommendationRequest;
use App\ViewModels\RecommendationViewModel;
use App\ViewModels\PropositionListViewModel;

class RecommendationController extends Controller {

    private RecommendationService $service;
    private PropositionService $service_prop;

    public function __construct(RecommendationService $service, PropositionService $service_prop) {
        $this->service = $service;
        $this->service_prop = $service_prop;
    }

    /**
     * @return View
     */
    public function propositions(): View {
        return view('district.propositions', new PropositionListViewModel([1, 2], auth()->user()->organ ?? 0));
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View {
        return view('district.index', new RecommendationViewModel(auth()->user()->organ ?? 0));
    }

    public function progress(): View {
        return view('district.progress', new RecommendationViewModel(auth()->user()->organ ?? 0, [4, 5], 2));
    }

    public function cancelled(): View {
        return view('district.cancelled', new RecommendationViewModel(auth()->user()->organ ?? 0, [6], 3));
    }

    public function archives(): View {
        $models = CancelledProposition::all();
        $provider = function($file): string {
            return '/storage/cancelled/' . $file;
        };
        return view('district.archives', ['models' => $models, 'provider' => $provider]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Proposition $proposition
     * @param string $type
     * @return View
     */
    public function create(Proposition $proposition, string $type): View {
        $recommendation = new Recommendation();
        return view("district.control.upsert", ['model' => $recommendation, 'proposition' => $proposition,
            'type' => $type, 'action' => route('district.recommendation.store', ['type' => $type]),
            'back' => route('district.propositions')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RecommendationRequest $request
     * @return RedirectResponse
     */

    public function store(RecommendationRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);

        $this->service_prop->show($this->getProposition($data['proposition_id']), 3);
        return redirect()->route('district.recommendations');
    }

    /**
     * void
     * @param Request $request
     * @param Recommendation $recommendation
     */
    public function upload(Request $request, Recommendation $recommendation) {
        $this->service->upload($request, $recommendation);
        $this->service_prop->show($recommendation->proposition, 4);
    }

    /**
     * Display the specified resource.
     *
     * @param Recommendation $recommendation
     * @return Response
     */
    public function show(Recommendation $recommendation): Response {
        return $this->service->show($recommendation);
    }

    public function proposition(Proposition $proposition): RedirectResponse {
        return $this->service_prop->show($proposition, 2);
    }

    public function add(): Collection {
        return Equipment::query()->pluck('name', 'id');
    }

    public function types(Equipment $equipment): Collection {
        return $equipment->types()->pluck('type', 'id');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Recommendation $recommendation
     * @return View
     */
    public function edit(Recommendation $recommendation): View {
        $type = $recommendation->type;
        return view('district.control.upsert', ['model' => $recommendation, 'proposition' => $recommendation->proposition,
            'type' => $type, 'action' => route('district.recommendation.update', ['recommendation' => $recommendation]),
            'back' => route('district.recommendations.cancelled')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RecommendationRequest $request
     * @param Recommendation $recommendation
     * @return RedirectResponse
     */
    public function update(RecommendationRequest $request, Recommendation $recommendation): RedirectResponse {
        $data = $request->validated();

        $this->service->update($data, $recommendation);
        $this->service_prop->update(['status' => 3], $recommendation->proposition);
        return redirect()->route('district.recommendations.cancelled');
    }

    private function getProposition(int $id): Proposition|Model {
        return Proposition::query()->find($id);
    }
}
