<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Project;
use App\ViewModels\ProjectViewModel;

class EngineerController extends Controller {
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    public function projects(): View {
        return view('engineer.projects', new ProjectViewModel([2], [11, 12]));
    }

    public function confirm(Request $request, Project $project): RedirectResponse {
        $this->projectService->confirm($request, $project);
        return redirect()->back();
    }

    public function cancel(Request $request, Project $project): RedirectResponse {
        $data = $request->validate(['comment' => ['required']])['comment'];
        $this->projectService->cancel($data, $project);
        return redirect()->back();
    }
}
