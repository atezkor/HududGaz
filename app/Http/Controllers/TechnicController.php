<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Services\RecommendationService;
use App\ViewModels\RecommendationViewModel;

class TechnicController extends Controller {
    private RecommendationService $rec_service;

    public function __construct(RecommendationService $service) {
        $this->rec_service = $service;
    }

    public function recommendations(): View {
        return view('technic.recommends', new RecommendationViewModel($this->rec_service, 0, [4, 5], 2));
    }

    public function show(Recommendation $recommendation): RedirectResponse {
        return $this->rec_service->techShow($recommendation);
    }

    public function create(Recommendation $recommendation): View {
        return view("technic.control.$recommendation->type");
    }

    public function store(Recommendation $recommendation): View {
        return view("technic.pdf.$recommendation->type");
    }

    public function edit() {

    }

    public function update() {
        $this->cancel();
    }

    public function back(Request $request, Recommendation $recommendation) {
        $this->rec_service->back($recommendation, $request['comment']);
    }

    public function index(): View {
        return view('technic.index');
    }

    private function accept() {
        $this->rec_service->accept();
    }

    private function cancel() {
        $this->rec_service->accept();
        $this->accept();
    }
}
