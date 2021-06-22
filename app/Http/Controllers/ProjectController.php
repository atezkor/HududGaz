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
        return view('designer.projects', new ProjectViewModel(designer: auth()->user()->organ ?? 0), [
            'qrcode' => $this->qrcode->generate(json_encode(['token' => csrf_token(), 'url' => route('designer.project.create')]))
        ]);
    }

    public function process(): View {
        return view('designer.process', new ProjectViewModel([2, 3], auth()->user()->organ ?? 0));
    }

    public function cancelled(): View {
        return view('designer.cancelled', new ProjectViewModel([4], auth()->user()->organ ?? 0));
    }

    public function create(Request $request): RedirectResponse {
        $this->service->create($request->get('code'));
        return redirect()->back();
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

    public function show(Request $request, Project $project): RedirectResponse {
        return response()->redirectTo($this->service->show($project, $request->get('show')));
    }

    public function delete(Project $project) {
        $this->service->delete($project);
    }

    public function archive(): View {
        return view('designer.archive', new ProjectViewModel([5], auth()->user()->organ ?? 0));
    }
}
