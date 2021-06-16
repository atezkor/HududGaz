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
        return view('designer.projects', new ProjectViewModel(organ: 1)); //auth()->user()->organ ?? 0
    }

    public function progress(): View {
        return view('designer.progress', new ProjectViewModel([2], [11], auth()->user()->organ ?? 0));
    }

    public function cancelled(): View {
        return view('designer.cancelled', new ProjectViewModel([3], [13], auth()->user()->organ ?? 0));
    }

    public function create(Request $request): RedirectResponse {
        $this->service->create($request->get('number'));
        return redirect()->route('designer.projects');
    }

    public function upload(Request $request, Project $project): RedirectResponse {
        $this->service->upload($request, $project);
        return redirect()->back();
    }

    public function show(Project $project): RedirectResponse {
        return redirect($this->service->show($project));
    }
}
