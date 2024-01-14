<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\License;
use App\Services\LicenseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class LicenseController extends Controller {

    private LicenseService $service;

    public function __construct(LicenseService $service) {
        $this->service = $service;
    }

    public function index(): View|RedirectResponse {
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
        return redirect('storage/permits/' . $permit->pdf);
    }

    public function upload(Request $request, License $permit): RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->upload($request->file('pdf'), $permit);
        return redirect()->back();
    }
}
