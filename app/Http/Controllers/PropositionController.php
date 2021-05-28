<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropositionRequest;
use App\Models\Activity;
use App\Models\Individual;
use App\Models\Proposition;
use App\Models\Region;
use App\Services\PropositionService;
use App\ViewModels\PropositionListViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PropositionController extends Controller {

    private PropositionService $service;

    public function __construct(PropositionService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        return view('propositions.index', new PropositionListViewModel($this->service));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse {
        $model = new Proposition();
        $organs = Region::query()->pluck('org_name', 'id');
        return view('propositions.form', ['action' => route('propositions.store'), 'method' => 'POST',
            'model' => $model, 'organs' => $organs,
            'activities' => Activity::all()->pluck('activity', 'id'), 'applicant' => new Individual()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropositionRequest $request
     * @return RedirectResponse
     */
    public function store(PropositionRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('propositions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Proposition $proposition
     * @return RedirectResponse
     */
    public function show(Proposition $proposition): RedirectResponse {
        return $this->service->show($proposition);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Proposition $proposition
     * @return View|RedirectResponse
     */
    public function edit(Proposition $proposition): View|RedirectResponse {
        $applicant = $proposition->applicant;

        $organs = Region::query()->pluck('org_name', 'id');
        return view('propositions.form', ['action' => route('propositions.update', ['proposition' => $proposition]),
            'method' => 'PUT', 'model' => $proposition, 'organs' => $organs,
            'activities' => Activity::all()->pluck('activity', 'id'), 'applicant' => $applicant]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PropositionRequest $request
     * @param Proposition $proposition
     * @return RedirectResponse
     */
    public function update(PropositionRequest $request, Proposition $proposition): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $proposition);
        return redirect()->route('propositions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Proposition $proposition
     * @return RedirectResponse
     */
    public function destroy(Proposition $proposition): RedirectResponse {
        $this->service->delete($proposition);
        return redirect()->route('propositions.index');
    }
}
