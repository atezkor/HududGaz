<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Project;
use App\Models\Designer;
use App\Models\Montage;
use App\Models\Mounter;
use App\Services\ProjectService;
use App\Services\MontageService;
use App\ViewModels\ProjectViewModel;
use App\ViewModels\MontageViewModel;

class EngineerController extends Controller {
    private ProjectService $projectService;
    private MontageService $montageService;

    public function __construct(ProjectService $projectService, MontageService $montageService) {
        $this->projectService = $projectService;
        $this->montageService = $montageService;
    }

    public function projects(): View {
        return view('engineer.projects', new ProjectViewModel([2, 3]), [
            'designers' => Designer::query()->pluck('org_name', 'id')
        ]);
    }

    public function montages(): View {
        return view('engineer.montages', new MontageViewModel([2, 3]), [
            'mounters' => Mounter::query()->pluck('short_name', 'id')
        ]);
    }

    public function project(Request $request, Project $project): RedirectResponse {
        if ($request->has('comment')) {
            $data = $request->validate(['comment' => ['required']])['comment'];
            $this->projectService->cancel($data, $project);
            return redirect()->back();
        }

        $this->projectService->confirm($request, $project);
        return redirect()->back();
    }

    public function montage(Request $request, Montage $montage): RedirectResponse {
        if ($request->has('comment')) {
            $data = $request->validate(['comment' => ['required']])['comment'];
            $this->montageService->cancel($data, $montage);
            return redirect()->back();
        }

        $this->montageService->confirm($request, $montage);
        return redirect()->back();
    }
}
