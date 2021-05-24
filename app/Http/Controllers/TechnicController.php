<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Services\RecommendationService;
use App\ViewModels\RecommendationViewModel;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TechnicController extends Controller {
    private RecommendationService $rec_service;

    public function __construct(RecommendationService $service) {
        $this->rec_service = $service;
    }

    public function index(): View|RedirectResponse {
        return view('technic.recommends', new RecommendationViewModel($this->rec_service, [4], 2));
    }

    public function show(Recommendation $recommendation): RedirectResponse {
        return $this->rec_service->show($recommendation, 1);
    }

    public function accept() {
        $this->rec_service->accept();
    }

    public function back(Request $request, Recommendation $recommendation) {
       $this->rec_service->back($recommendation, $request->get('comment'));
    }
}
