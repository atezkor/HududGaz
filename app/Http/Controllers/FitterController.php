<?php

namespace App\Http\Controllers;

use App\Http\Requests\FitterRequest;
use App\Models\Fitter;
use App\Services\MounterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FitterController extends Controller {
    private MounterService $service;

    public function __construct(MounterService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse {
        app()->setLocale('uz');

        $firm = $request->get('firm');
        $models = Fitter::query()->where('firm_id', '=', $firm)->get();
        return view('admin.mounters.workers', ['models' => $models, 'firm_id' => $firm]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function create(Request $request): View|RedirectResponse {
        app()->setLocale('uz');

        $model = new Fitter();
        $firm = $request->get('firm');
        return view('admin.mounters.manage', ['action' => route('admin.fitters.store'),
            'method' => 'POST', 'model' => $model, 'firm_id' => $firm]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FitterRequest $request
     * @return RedirectResponse
     */
    public function store(FitterRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->worker($data, new Fitter());

        $firm = $request->get('firm_id');
        return redirect()->route('admin.fitters.index', ['firm' => $firm]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Fitter $fitter
     * @return View|RedirectResponse
     */
    public function edit(Fitter $fitter): View|RedirectResponse {
        app()->setLocale('uz');

        return view('admin.mounters.manage', ['action' => route('admin.fitters.update', ['fitter' => $fitter]),
            'method' => 'PUT', 'model' => $fitter]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FitterRequest $request
     * @param Fitter $fitter
     * @return RedirectResponse
     */
    public function update(FitterRequest $request, Fitter $fitter): RedirectResponse {
        $data = $request->validated();
        $this->service->worker($data, $fitter);

        $firm = $request->get('firm_id');
        return redirect()->route('admin.fitters.index', ['firm' => $firm]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Fitter $fitter
     * @return RedirectResponse
     */
    public function destroy(Fitter $fitter): RedirectResponse {
        $this->service->deleteWorker($fitter);
        return redirect()->route('admin.fitters.index', ['firm' => $fitter->getAttribute('firm_id')]);
    }
}
