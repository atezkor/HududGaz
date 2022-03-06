<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use App\Models\Project;
use App\Models\Designer;
use App\Models\Montage;
use App\Models\Mounter;
use App\Models\License;
use App\Services\ProjectService;
use App\Services\MontageService;
use App\Services\LicenseService;
use App\ViewModels\ProjectViewModel;
use App\ViewModels\MontageViewModel;


class EngineerController extends Controller {

    private ProjectService $projectService;
    private MontageService $montageService;
    private LicenseService $licenseService;

    public function __construct(ProjectService $projectService, MontageService $montageService, LicenseService $licenseService) {
        $this->projectService = $projectService;
        $this->montageService = $montageService;
        $this->licenseService = $licenseService;
    }

    public function projects(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('engineer.projects', new ProjectViewModel([2, 3]), [
            'designers' => Designer::query()->pluck('org_name', 'id')
        ]);
    }

    public function montages(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('engineer.montages', new MontageViewModel([2, 3]), [
            'mounters' => Mounter::query()->pluck('short_name', 'id')
        ]);
    }

    public function project(Request $request, Project $project): RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($request->has('comment')) {
            $data = $request->validate(['comment' => ['required']])['comment'];
            $this->projectService->cancel($data, $project);
            return redirect()->back();
        }

        $this->projectService->confirm($request, $project);
        return redirect()->back();
    }

    public function montage(Request $request, Montage $montage): RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($request->has('comment')) {
            $this->montageService->cancel($request->comment, $montage);
            return redirect()->back();
        }

        $this->montageService->action($request, $montage);
        $this->licenseService->createLicense($montage);
        return redirect()->back();
    }

    public function permits(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = License::with('project', 'montage')
            ->where('status', 1)
            ->get();
        return view('engineer.permits', [
            'models' => $models,
            'districts' => districts()
        ]);
    }

    public function show(License $permit): RedirectResponse {
        return redirect('storage/permits/' . $permit->file);
    }

    public function upload(Request $request, License $permit): RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->storeFile($request->file('file'), $permit);
        return redirect()->back();
    }

    public function completedProjects(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('designer.archive', new ProjectViewModel([5]));
    }

    public function archiveMontages(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('installer.archive', new MontageViewModel([5]));
    }

    private function storeFile(UploadedFile $file, License $permit) {
        File::delete('storage/permits/' . $permit->file);
        $filename = time() . $file->extension();
        $file->storeAs('public/permits', $filename);

        $permit->update(['file' => $filename, 'status' => 2]);
        $permit->proposition->update(['status' => 20]);
    }
}
