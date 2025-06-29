<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropositionRequest;
use App\Models\Activity;
use App\Models\CancelledProposition;
use App\Models\Organ;
use App\Models\PhysicalApplicant;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Models\User;
use App\Services\PropositionService;
use App\ViewModels\PropositionListViewModel;
use App\ViewModels\RecommendationViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
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
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse {
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $organs = Organ::all();
        $activities = Activity::query()->pluck('activity', 'id'); //->skip(1) //->take(5)

        return view('technic.applications.create', [
            'model' => new Proposition(),
            'applicant' => new PhysicalApplicant(),
            'organs' => $organs,
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
        $url = $this->service->view($proposition);
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

        $applicant = $proposition->applicant->petitioner;
        $organs = Organ::all();
        $activities = Activity::query()->pluck('activity', 'id'); // ->skip(1)->take(5)->pluck('activity', 'id');
        return view('technic.applications.edit', [
            'model' => $proposition,
            'applicant' => $applicant,
            'organs' => $organs,
            'activities' => $activities
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

    /**
     * @param Proposition $proposition
     * @return RedirectResponse
     */
    public function view(Proposition $proposition): RedirectResponse {
        $url = $this->service->view($proposition, Proposition::REVIEWED);
        return redirect($url);
    }

    /**
     * Check for application with this tin for existing
     * @param int $type
     * @param int $tinPin
     * @return Model
     */
    public function check(int $type, int $tinPin): Model {
        return $this->service->checkTin($type, $tinPin);
    }

    /**
     *
     * @param int $type
     * @param int $tin
     * @return View|RedirectResponse
     */
    public function exist(int $type, int $tin): View|RedirectResponse {
        try {
            $this->authorize('crud_prop');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.applications.exist', [
            'models' => $this->service->exist($type, $tin),
            'organs' => Organ::query()->pluck('name', 'id'),
            'type' => $type,
            'tin' => $tin
        ]);
    }

    /**
     * Organ applications list
     * @return View|RedirectResponse
     */
    public function organ(): View|RedirectResponse {
        /* @var User $user */
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('organ.propositions.index', new PropositionListViewModel([Proposition::CREATED, Proposition::REVIEWED], $user->organization_id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Proposition $proposition
     * @param string $type
     * @return View|RedirectResponse
     */
    public function statement(Proposition $proposition, string $type): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $recommendation = new Recommendation();
        return view("organ.statements.upsert", [
            'model' => $recommendation,
            'proposition' => $proposition,
            'type' => $type,
            'action' => route('organ.recommendation.store')
        ]);
    }

    /**
     * This shows all propositions
     * @return View|RedirectResponse
     */
    public function all(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.applications.index', new PropositionListViewModel());
    }

    public function archive(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();

        $models = CancelledProposition::all();
        $provider = function(string $pdf): string {
            return '/storage/cancelled/' . $pdf;
        };

        $statuses = [
            // These are also finished, because they have passed next stage
            Proposition::PROJECT_C, Proposition::PROJECT_CREATED,
            11, 12, 13, 14, 15,
            16, 17, 18, 19, 20
        ]; // TODO statuses
        return view('organ.archives', new RecommendationViewModel(
            $statuses, [Recommendation::COMPLETED], $user->organization_id
        ), [
            'models' => $models,
            'provider' => $provider
        ]);
    }
}
