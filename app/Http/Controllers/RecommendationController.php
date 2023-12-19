<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecommendationRequest;
use App\Models\CancelledProposition;
use App\Models\EquipmentType;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Models\User;
use App\Services\PropositionService;
use App\Services\RecommendationService;
use App\ViewModels\PropositionListViewModel;
use App\ViewModels\RecommendationViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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

        return view('district.index', new RecommendationViewModel(organ: request()->user()->organ));
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

        $this->propService->view($this->getProposition($data['proposition_id']), 3);
        return redirect()->route('district.recommendations');
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
        return view('district.control.upsert', [
            'model' => $recommendation,
            'proposition' => $recommendation->proposition,
            'type' => $type,
            'action' => route('district.recommendation.update', ['recommendation' => $recommendation]),
            'back' => route('district.recommendations.cancelled')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
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
        return redirect()->route('district.recommendations.cancelled');
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

        $this->service->upload($request, $recommendation);
        $this->propService->view($recommendation->proposition, 4);
        return redirect()->back();
    }

    public function progress(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('district.progress', new RecommendationViewModel([4, 5], 2, request()->user()->organ));
    }

    public function cancelled(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('district.cancelled', new RecommendationViewModel([6], 3, request()->user()->organ));
    }

    public function archives(): View|RedirectResponse {
        try {
            $this->authorize('crud_rec');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = CancelledProposition::all();
        $provider = function($file): string {
            return '/storage/cancelled/' . $file;
        };

        return view('district.archives',
            new RecommendationViewModel(
                [7, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
                4,
                request()->user()->organ
            ),
            ['models' => $models, 'provider' => $provider]
        );
    }

    public function add(): Collection {
        return EquipmentType::query()->pluck('name', 'id');
    }

    public function types(EquipmentType $equipment): Collection {
        return $equipment->types()->pluck('type', 'id');
    }

    private function getProposition(int $id): Proposition|Model {
        return Proposition::query()->find($id);
    }
}
