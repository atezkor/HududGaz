<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Montage;
use App\Services\MontageService;
use App\ViewModels\MontageViewModel;
use SimpleSoftwareIO\QrCode\Generator;

class MontageController extends Controller {

    private Generator $qrcode;
    private MontageService $service;

    public function __construct(MontageService $service, Generator $generator) {
        $this->service = $service;
        $this->qrcode = $generator;
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        return view('installer.index', new MontageViewModel(user: auth()->user()), [
            'qrcode' => $this->qrcode->generate(json_encode([
                'token' => csrf_token(),
                'url' => route('mounter.project.open')
            ]))
        ]);
    }

    public function open(Request $request): RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $this->service->create($request->get('code'));
        return redirect()->back();
    }

    public function upload(Request $request, Montage $montage): RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $this->service->upload($request, $montage);
        return redirect()->back();
    }

    public function process(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        return view('installer.process', new MontageViewModel([2, 3], auth()->user()));
    }

    public function show(Request $request, Montage $montage): RedirectResponse {
        return redirect($this->service->show($montage, $request->get('show')));
    }

    public function cancelled(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        return view('installer.cancelled', new MontageViewModel([4], auth()->user()));
    }

    public function archive(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        return view('installer.archive', new MontageViewModel([5]));
    }

    public function delete(Montage $montage): RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $this->service->delete($montage);

        return redirect()->back();
    }
}
