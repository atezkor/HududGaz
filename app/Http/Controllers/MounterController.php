<?php

namespace App\Http\Controllers;

use App\Http\Requests\MounterRequest;
use App\Models\Base;
use App\Models\Mounter;
use App\Services\MounterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MounterController extends Controller {
    private MounterService $service;

    public function __construct(MounterService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        $models = Mounter::all();
        return view('admin.mounters.index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse {
        $model = new Mounter();
        return view('admin.mounters.form', ['action' => route('admin.mounters.store'),
            'method' => 'POST', 'model' => $model, 'districts' => Base::districts()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MounterRequest $request
     * @return RedirectResponse
     */
    public function store(MounterRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.mounters.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Mounter $mounter
     * @return View|RedirectResponse
     */
    public function edit(Mounter $mounter): View|RedirectResponse {
        return view('admin.mounters.form', ['action' => route('admin.mounters.update', ['mounter' => $mounter]),
            'method' => 'PUT', 'model' => $mounter, 'districts' => Base::districts()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MounterRequest $request
     * @param Mounter $mounter
     * @return RedirectResponse
     */
    public function update(MounterRequest $request, Mounter $mounter): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $mounter);
        return redirect()->route('admin.mounters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Mounter $mounter
     * @return RedirectResponse
     */
    public function destroy(Mounter $mounter): RedirectResponse {
        $this->service->delete($mounter);
        return redirect()->route('admin.mounters.index');
    }
}
