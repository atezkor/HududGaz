<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\MontageService;
use SimpleSoftwareIO\QrCode\Generator;

class MontageController extends Controller {

    private Generator $qrcode;
    private MontageService $service;

    public function __construct(MontageService $service, Generator $generator) {
        $this->service = $service;
        $this->qrcode = $generator;
    }

    public function index(): View {
        return view('installer.index', [], [
            'qrcode' => $this->qrcode->generate(json_encode([
                'token' => csrf_token(),
                'url' => route('mounter.project.open')
            ]))
        ]);
    }

    public function open(Request $request): RedirectResponse {
        $this->service->create($request->get('code'));
        return redirect()->back();
    }
}
