<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
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

    public function index(): View|RedirectResponse {
        return view('designer.projects', new ProjectViewModel(designer: auth()->user()->organ ?? 0), [
            'qrcode' => $this->qrcode->generate(json_encode(['token' => csrf_token(), 'url' => route('designer.project.create')]))
        ]);
    }

    public function process(): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        return view('designer.process', new ProjectViewModel([2, 3], auth()->user()->organ ?? 0));
    }

    public function cancelled(): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        return view('designer.cancelled', new ProjectViewModel([4], auth()->user()->organ ?? 0));
    }

    public function create(Request $request): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $this->service->create($request->get('code'));
        return redirect()->back();
    }

    public function upload(Request $request, Project $project): RedirectResponse|View {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

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

    public function delete(Project $project): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $this->service->delete($project);
        return redirect()->back();
    }

    public function archive(): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        return view('designer.archive', new ProjectViewModel([5], auth()->user()->organ ?? 0));
    }
}
