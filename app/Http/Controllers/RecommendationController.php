<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecommendationRequest;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Services\PropositionService;
use App\Services\RecommendationService;
use App\ViewModels\PropositionListViewModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecommendationController extends Controller {

    private RecommendationService $service;
    private PropositionService $service_prop;

    public function __construct(RecommendationService $service, PropositionService $service_prop) {
        $this->service = $service;
        $this->service_prop = $service_prop;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        $models = Recommendation::all();
        return view('district.index', ['models' => $models]);
    }

    /**
     * @return View|RedirectResponse
     */
    public function propositions(): View|RedirectResponse {
        return view('district.propositions', new PropositionListViewModel($this->service_prop, [1, 2]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Proposition $proposition
     * @param $type
     * @return View|RedirectResponse
     */
    public function create(Proposition $proposition, $type): View|RedirectResponse {
        return view("district.create", ['model' => $proposition, 'type' => $type]);
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
     */
    public function upload(Request $request, Recommendation $recommendation) {
        $this->service->upload($request);
        $this->service_prop->show($recommendation->proposition(), 4);
    }

    /**
     * Display the specified resource.
     *
     * @param Recommendation $recommendation
     * @return RedirectResponse
     */
    public function show(Recommendation $recommendation): RedirectResponse {
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
        return view('', ['model' => $recommendation]);
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
        return redirect()->route('district.recommendations');
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

    private function getProposition($id): Proposition|Model {
        return Proposition::query()->find($id);
    }
}
