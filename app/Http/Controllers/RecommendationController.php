<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecommendationRequest;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Services\PropositionService;
use App\Services\RecommendationService;
use App\ViewModels\RecommendationViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class RecommendationController extends Controller {

    private RecommendationService $service;
    private PropositionService $propService;

    public function __construct(RecommendationService $service, PropositionService $propService) {
        $this->service = $service;
        $this->propService = $propService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('organ.recommendations', new RecommendationViewModel(organizationId: $user->organization_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RecommendationRequest $request
     * @return RedirectResponse
     */

    public function store(RecommendationRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->create($data);

        return redirect()->route('organ.recommendations');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param Recommendation $recommendation
     * @return View|RedirectResponse
     */
    public function edit(Recommendation $recommendation): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $type = $recommendation->type;
        return view('organ.statements.upsert', [
            'model' => $recommendation,
            'proposition' => $recommendation->proposition,
            'type' => $type,
            'action' => route('organ.recommendation.update', $recommendation->id),
            'back' => route('organ.recommendations.cancelled')
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param RecommendationRequest $request
     * @param Recommendation $recommendation
     * @return RedirectResponse
     */
    public function update(RecommendationRequest $request, Recommendation $recommendation): RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();

        $this->service->update($data, $recommendation);
        $this->propService->update(['status' => 3], $recommendation->proposition);
        return redirect()->route('organ.recommendations.cancelled');
    }

    public function view(Recommendation $recommendation): RedirectResponse {
        $url = $this->service->view($recommendation);
        return redirect($url);
    }

    /**
     * void
     * @param Request $request
     * @param Recommendation $recommendation
     * @return RedirectResponse
     */
    public function upload(Request $request, Recommendation $recommendation): RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->upload($request->file('pdf'), $recommendation);
        return redirect()->back();
    }

    public function back(Request $request, Recommendation $recommendation): RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->back($recommendation, $request['comment']);
        return redirect()->back();
    }

    public function progress(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('organ.progress', new RecommendationViewModel([], [Recommendation::PRESENTED], $user->organization_id));
    }

    public function cancelled(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('organ.cancelled', new RecommendationViewModel([], [Recommendation::REJECTED], $user->organization_id));
    }

    public function technic(): View|RedirectResponse {
        try {
            $this->authorize('crud_tech');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.recommendations', new RecommendationViewModel([], [Recommendation::PRESENTED]));
    }

    public function director(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('technic.recommendations', new RecommendationViewModel([Proposition::IN_PROCESS, Proposition::COMPLETED], [Recommendation::PRESENTED]));
    }
}
