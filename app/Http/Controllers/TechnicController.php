<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Services\RecommendationService;
use App\ViewModels\RecommendationViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TechnicController extends Controller {
    private RecommendationService $service;

    public function __construct(RecommendationService $service) {
        $this->service = $service;
    }

    public function index(): View|RedirectResponse {
        return view('technic.recommends', new RecommendationViewModel($this->service, 4));
    }

    public function show(Recommendation $recommendation): RedirectResponse {
        return $this->service->show($recommendation, 1);
    }
}
