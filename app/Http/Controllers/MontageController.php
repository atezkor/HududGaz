<?php

namespace App\Http\Controllers;

use App\Models\Montage;
use App\Models\User;
use App\Services\MontageService;
use App\ViewModels\MontageViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Generator;


class MontageController extends Controller {

    private Generator $qrcode;
    private MontageService $service;

    public function __construct(MontageService $service, Generator $generator) {
        $this->service = $service;
        $this->qrcode = $generator;
    }

    public function index(): View|RedirectResponse {
        /* @var User $user */
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = auth()->user();
        return view('installer.montages', new MontageViewModel(organizationId: $user->organization_id), [
            'qrcode' => $this->qrcode->generate(json_encode([
                'token' => csrf_token(),
                'url' => route('mounter.project.open')
            ]))
        ]);
    }

    public function engineer(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('engineer.montages', new MontageViewModel([Montage::CREATED, Montage::REVIEWED]));
    }

    public function show(Request $request, Montage $montage): RedirectResponse {
        return redirect($this->service->show($montage, $request->get('show')));
    }

    public function update(Request $request, Montage $montage): RedirectResponse {
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

    public function delete(Montage $montage): RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->delete($montage);
        return redirect()->back();
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

    public function process(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('installer.process', new MontageViewModel([Montage::ACCEPTED, Montage::REVIEWED], $user->organization_id));
    }

    public function cancelled(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('installer.cancelled', new MontageViewModel([Montage::CANCELLED], $user->organization_id));
    }

    public function archive(): View|RedirectResponse {
        try {
            $this->authorize('crud_montage');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        return view('installer.archive', new MontageViewModel([Montage::COMPLETED], $user->organization_id));
    }

    /**
     * Engineer
     */
    public function completed(): View|RedirectResponse {
        try {
            $this->authorize('crud_permit');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('installer.archive', new MontageViewModel([Montage::COMPLETED]));
    }

    /**
     * Director
     * @return View|RedirectResponse
     */
    public function director(): \Illuminate\Contracts\View\View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('installer.archive', new MontageViewModel([Montage::COMPLETED]));
    }
}
