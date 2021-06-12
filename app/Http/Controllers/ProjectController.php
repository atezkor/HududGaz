<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller {

    private ProjectService $service;

    public function __construct(ProjectService $service) {
        $this->service = $service;
    }

    public function index(): View {
        return view('designer.projects');
    }

    public function progress(): View {
        return view('designer.projects');
    }

    public function cancelled(): View {
        return view('designer.projects');
    }

    public function add(Request $request): RedirectResponse {
        $this->service->read($request);
        return redirect()->route('designer.projects');
    }
}
