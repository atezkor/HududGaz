<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropositionRequest;
use App\Models\Activity;
use App\Models\IndividualApplicant;
use App\Models\Organ;
use App\Models\Proposition;
use App\Models\User;
use App\Services\PropositionService;
use App\ViewModels\PropositionListViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


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

        return view('technic.applications.index', new PropositionListViewModel());
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
        $organs = Organ::query()->pluck('name', 'id');
        $activities = Activity::query()
            ->skip(1)
            ->take(5)
            ->pluck('activity', 'id');

        return view('technic.propositions.create', [
            'model' => $model, 'organs' => $organs,
            'applicant' => new IndividualApplicant(),
            'activities' => $activities
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
        $url = $this->service->show($proposition);
        return redirect($url);
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
        $organs = Organ::query()->pluck('org_name', 'id');
        return view('technic.form', [
            'action' => route('propositions.update', ['proposition' => $proposition]),
            'method' => 'PUT', 'model' => $proposition,
            'applicant' => $applicant,
            'organs' => $organs,
            'activities' => Activity::query()->skip(1)->take(5)->pluck('activity', 'id')
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

    public function available(int $type, int $stir): View|RedirectResponse {
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.filter', [
            'models' => $this->service->available($type, $stir),
            'organs' => Organ::query()->pluck('org_name', 'id'),
            'type' => $type,
            'stir' => $stir
        ]);
    }

    /**
     * @return \Illuminate\View\View|RedirectResponse
     */
    public function organ(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        /* @var User $user */
        $user = request()->user();
        return view('organ.propositions.index', new PropositionListViewModel([Proposition::CREATED, Proposition::CREATED_T], $user->organization_id));
    }
}
