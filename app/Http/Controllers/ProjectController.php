<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Services\ProjectService;
use App\ViewModels\ProjectViewModel;

class ProjectController extends Controller {
    private ProjectService $service;

    public function __construct(ProjectService $service) {
        $this->service = $service;
    }

    public function index(): View {
        return view('designer.projects', new ProjectViewModel());
    }

    public function progress(): View {
        return view('designer.projects');
    }

    public function cancelled(): View {
        return view('designer.projects');
    }

    public function create(Request $request): RedirectResponse {
        $this->service->create($request);
        return redirect()->route('designer.projects');
    }

    public function upload(Request $request, Project $project): RedirectResponse {
        $this->service->upload($request, $project);
        return redirect()->back();
    }
}
