<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecommendationRequest;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Services\PropositionService;
use App\Services\RecommendationService;
use App\ViewModels\PropositionListViewModel;
use App\ViewModels\RecommendationViewModel;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecommendationController extends Controller {

    private RecommendationService $service;
    private PropositionService $service_prop;

    public function __construct(RecommendationService $service, PropositionService $service_prop) {
        $this->service = $service;
        $this->service_prop = $service_prop;
    }

    /**
     * @return View|RedirectResponse
     */
    public function propositions(): View|RedirectResponse {
        return view('district.propositions', new PropositionListViewModel($this->service_prop, [1, 2]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        return view('district.index', new RecommendationViewModel($this->service));
    }

    public function cancelled(): View|RedirectResponse {
        return view('district.cancelled', new RecommendationViewModel($this->service, [6], 3));
    }

    public function archives(): View|RedirectResponse {
        return view('district.archives');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $proposition
     * @param string $type
     * @return View|RedirectResponse
     */
    public function create(int $proposition, string $type): View|RedirectResponse {
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param Recommendation $recommendation
     * @return View|RedirectResponse
     */
    public function edit(Recommendation $recommendation): View|RedirectResponse {
        $type = $recommendation->type;
        return view('district.control.upsert', ['model' => $recommendation, 'proposition' => $recommendation->proposition->id,
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
        $this->service_prop->update(['status' => 5], $recommendation->proposition);
        return redirect()->route('district.recommendations.cancelled');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Recommendation $recommendation
     * @return RedirectResponse
     */
    public function destroy(Recommendation $recommendation): RedirectResponse {
        $this->service->delete($recommendation);
        return redirect()->route('district.recommendations');
    }

    private function getProposition(int $id): Proposition|Model {
        return Proposition::query()->find($id);
    }
}
