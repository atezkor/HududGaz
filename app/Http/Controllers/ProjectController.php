<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Models\Organization;
use App\Services\ProjectService;
use App\ViewModels\ProjectViewModel;
use SimpleSoftwareIO\QrCode\Generator;

class ProjectController extends Controller {
    private ProjectService $service;
    private Generator $qrcode;

    public function __construct(ProjectService $service, Generator $qrcode) {
        $this->service = $service;
        $this->qrcode = $qrcode;
    }

    public function index(): View {
        return view('designer.projects', new ProjectViewModel(organ: auth()->user()->organ ?? 0), [
            'qrcode' => $this->qrcode->size(100)->generate(csrf_token())
        ]);
    }

    public function progress(): View {
        return view('designer.progress', new ProjectViewModel([2], [11], auth()->user()->organ ?? 0));
    }

    public function cancelled(): View {
        return view('designer.cancelled', new ProjectViewModel([3], [13], auth()->user()->organ ?? 0));
    }

    public function create(Request $request): RedirectResponse {
        $this->service->create($request->get('code'));
        return redirect()->route('designer.projects');
    }

    public function upload(Request $request, Project $project): RedirectResponse|View {
        if (!$request->has('download')) { // If not have download key
            $this->service->upload($request, $project);
            return redirect()->back();
        }

        $proposition = $project->proposition;
        return view('designer.explanatory-letter', [
            'proposition' => $proposition, 'applicant' => $proposition->applicant,
            'recommendation' => $proposition->recommendation,
            'build_type' => [__('designer.residential'), __('designer.nonresidential')][$proposition->build_type - 1],
            'condition' => $proposition->tech_condition,
            'organization' => Organization::Data()->shareholder_name,
        ]);
    }

    public function show(Project $project): RedirectResponse {
        return response()->redirectTo($this->service->show($project));
    }
}
