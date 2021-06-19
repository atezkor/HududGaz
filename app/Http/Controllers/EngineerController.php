<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use App\Models\Project;
use App\Models\Designer;
use App\Services\ProjectService;
use App\ViewModels\ProjectViewModel;

class EngineerController extends Controller {
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    public function projects(): View {
        return view('engineer.projects', new ProjectViewModel([2, 3]), [
            'designers' => $this->designers()
        ]);
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

    private function designers(): Collection {
        return Designer::query()->pluck('org_name', 'id');
    }
}
