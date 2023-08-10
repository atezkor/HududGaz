<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Generator;
use App\Models\Montage;
use App\Services\MontageService;
use App\ViewModels\MontageViewModel;


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
            return redirect('/');
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
            return redirect('/');
        }

        $this->service->create($request->get('code'));
        return redirect()->back();
    }

    public function upload(Request $request, Montage $montage): RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($request->has('diameter')) {
            $this->service->updatePart($request->get('diameter'), $montage);
            redirect()->back();
        }

        $data = $request->validate(['file' => ['required']]);
        $this->service->upload($data, $montage);
        return redirect()->back();
    }

    public function process(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
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
            return redirect('/');
        }

        return view('installer.cancelled', new MontageViewModel([4], auth()->user()));
    }

    public function archive(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('installer.archive', new MontageViewModel([Montage::COMPLETED]));
    }

    public function delete(Montage $montage): RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->delete($montage);
        return redirect()->back();
    }
}
