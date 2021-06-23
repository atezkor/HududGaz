<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Mounter;
use App\Services\MounterService;
use App\Http\Requests\MounterRequest;

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
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $models = Mounter::all();
        return view('admin.mounters.index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $model = new Mounter();
        return view('admin.mounters.form', ['action' => route('admin.mounters.store'),
            'method' => 'POST', 'model' => $model, 'districts' => districts()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MounterRequest $request
     * @return RedirectResponse
     */
    public function store(MounterRequest $request): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

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
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        return view('admin.mounters.form', ['action' => route('admin.mounters.update', ['mounter' => $mounter]),
            'method' => 'PUT', 'model' => $mounter, 'districts' => districts()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MounterRequest $request
     * @param Mounter $mounter
     * @return RedirectResponse
     */
    public function update(MounterRequest $request, Mounter $mounter): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

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
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $this->service->delete($mounter);
        return redirect()->route('admin.mounters.index');
    }
}
