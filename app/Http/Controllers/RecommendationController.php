<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecommendationRequest;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Services\Service;
use App\ViewModels\PropositionListViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecommendationController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Recommendation());
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        return view('district.index', new PropositionListViewModel());
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
        return redirect()->route('district.recommendations');
    }

    /**
     * Display the specified resource.
     *
     * @param Recommendation $recommendation
     * @return View|RedirectResponse
     */
    public function show(Recommendation $recommendation): View|RedirectResponse {
        return view('', ['r' => $recommendation]);
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
}
