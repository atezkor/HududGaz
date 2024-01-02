<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use App\ViewModels\ProjectViewModel;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ProjectController extends Controller {

    private ProjectService $service;

    public function __construct(ProjectService $service) {
        $this->service = $service;
    }

    public function index(): View|RedirectResponse {
        /* @var User $user */
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('designer.projects', new ProjectViewModel($user->organization_id), [
            'qrcode' => $this->service->qrcode($user)
        ]);
    }

    public function store(ProjectCreateRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        try {
            $this->service->create($request->validated());
            return redirect()->back()->with('msg', __('global.messages.crt'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', __('global.msg.not_found'));
        }
    }

    public function show(Request $request, Project $project): RedirectResponse {
        return response()->redirectTo($this->service->show($project, $request->get('show')));
    }

    public function update(Request $request, Project $project): RedirectResponse|View {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($request->has('download')) {
            $data = $this->service->generateLetter($project);
            return view('designer.pdf.explanatory-letter', $data);
        }

        $file = $request->validate(['pdf' => ['required']]);
        $this->service->upload($file, $project);
        return redirect()->back();
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

    public function process(): View|RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('designer.process', new ProjectViewModel(
            $user->organization_id,
            [Project::ACCEPTED, Project::REVIEWED]
        ));
    }

    public function cancelled(): View|RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('designer.cancelled', new ProjectViewModel($user->organization_id, [Project::CANCELLED]));
    }

    public function archive(): View|RedirectResponse {
        try {
            $this->authorize('crud_project');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('designer.archive', new ProjectViewModel($user->organization_id, [Project::COMPLETED]));
    }

    public function engineer(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('engineer.projects', new ProjectViewModel(0, [Project::ACCEPTED, Project::REVIEWED]));
    }

    /**
     * Engineer archive
     */
    public function completed(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('designer.archive', new ProjectViewModel(0, [Project::COMPLETED]));
    }

    /**
     * Director
     * @return View|RedirectResponse
     */
    public function director(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('designer.archive', new ProjectViewModel(0, [Project::COMPLETED]));
    }
}
