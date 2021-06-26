<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Activity;
use App\Models\Region;
use App\Services\PropositionService;
use App\Http\Requests\PropositionRequest;
use App\ViewModels\PropositionListViewModel;

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
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.propositions', new PropositionListViewModel());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|RedirectResponse
     * If Query -> All => pluck return Models
     */
    public function create(): View|RedirectResponse {
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $model = new Proposition();
        $organs = Region::query()->pluck('org_name', 'id');
        return view('technic.form', ['action' => route('propositions.store'), 'method' => 'POST',
            'model' => $model, 'organs' => $organs,
            'applicant' => new Individual(),
            'activities' => Activity::query()->pluck('activity', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropositionRequest $request
     * @return RedirectResponse
     */
    public function store(PropositionRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

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
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $applicant = $proposition->applicant;
        $organs = Region::query()->pluck('org_name', 'id');
        return view('technic.form', ['action' => route('propositions.update', ['proposition' => $proposition]),
            'method' => 'PUT', 'model' => $proposition,
            'applicant' => $applicant,
            'organs' => $organs,
            'activities' => Activity::query()->pluck('activity', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PropositionRequest $request
     * @param Proposition $proposition
     * @return RedirectResponse
     */
    public function update(PropositionRequest $request, Proposition $proposition): RedirectResponse {
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

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
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->delete($proposition);
        return redirect()->route('propositions.index');
    }

    public function propositions(int $type, int $stir): View {
        return view('technic.filter', [
            'models' => Proposition::query()->whereHas($type == 1 ? 'individual' : 'legal', function(Builder $query) use ($type, $stir) {
                if ($type == 1)
                    $query->where('stir', $stir);
                elseif($type == 2)
                    $query->where('legal_stir', $stir);
                else
                    $query->where('leader_stir', $stir);
            })->get(['id', 'number', 'type', 'organ', 'created_at']),
            'organs' => Region::query()->pluck('org_name', 'id'),
            'type' => $type,
            'stir' => $stir
        ]);
    }
}
