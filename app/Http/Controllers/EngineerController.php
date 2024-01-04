<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\License;
use App\Models\Montage;
use App\Services\LicenseService;
use App\Services\MontageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class EngineerController extends Controller {

    private MontageService $montageService;
    private LicenseService $licenseService;

    public function __construct(MontageService $montageService, LicenseService $licenseService) {
        $this->montageService = $montageService;
        $this->licenseService = $licenseService;
    }

    public function montage(Request $request, Montage $montage): RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($request->has('comment')) {
            $this->montageService->cancel($request->get('comment'), $montage);
            return redirect()->back();
        }

        $this->montageService->action($request->file('file'), $montage);
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
            ->where('status', License::CREATED)
            ->get();
        return view('engineer.permits', [
            'models' => $models,
            'districts' => District::query()->pluck('name', 'id')
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

        $this->licenseService->upload($request->file('file'), $permit);
        return redirect()->back();
    }
}
