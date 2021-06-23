<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Designer;
use App\Http\Requests\DesignerRequest;
use App\Services\DesignerService;

class DesignerController extends Controller {

    private DesignerService $service;

    public function __construct(DesignerService $service) {
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

        $models = Designer::all();
        return view('admin.designers.index', ['models' => $models]);
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

        $model = new Designer();
        return view('admin.designers.form', ['action' => route('admin.designers.store'),
            'method' => 'POST', 'model' => $model]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DesignerRequest $request
     * @return RedirectResponse
     */
    public function store(DesignerRequest $request): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.designers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Designer $designer
     * @return View|RedirectResponse
     */
    public function edit(Designer $designer): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        return view('admin.designers.form', ['action' => route('admin.designers.update', ['designer' => $designer]),
            'method' => 'PUT', 'model' => $designer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DesignerRequest $request
     * @param Designer $designer
     * @return RedirectResponse
     */
    public function update(DesignerRequest $request, Designer $designer): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $data = $request->validated();
        $this->service->update($data, $designer);
        return redirect()->route('admin.designers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Designer $designer
     * @return RedirectResponse
     */
    public function destroy(Designer $designer): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $this->service->delete($designer);
        return redirect()->route('admin.designers.index');
    }
}
