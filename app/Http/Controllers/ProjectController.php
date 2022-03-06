<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
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
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('designer.projects', new ProjectViewModel(designer: request()->user()->organ), [
            'qrcode' => $this->qrcode->generate(json_encode([
                'token' => csrf_token(),
                'url' => route('designer.project.create_api', ['user' => request()->user()])
            ]))
        ]);
    }

    public function process(): View|RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('designer.process', new ProjectViewModel([2, 3], request()->user()->organ));
    }

    public function cancelled(): View|RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('designer.cancelled', new ProjectViewModel([4], request()->user()->organ));
    }

    public function create(Request $request): RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->create($request->get('code'));
        return redirect()->back();
    }

    public function upload(Request $request, Project $project): RedirectResponse|View {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($request->has('download')) {
            return $this->service->generateLetter($project);
        }

        $this->service->upload($request, $project);
        return redirect()->back();
    }

    public function show(Request $request, Project $project): RedirectResponse {
        return response()->redirectTo($this->service->show($project, $request->get('show')));
    }

    public function delete(Project $project): RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->delete($project);
        return redirect()->back();
    }

    public function archive(): View|RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $organ = request()->user()->organ;
        return view('designer.archive', new ProjectViewModel([5], $organ));
    }
}
