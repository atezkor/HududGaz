<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignerRequest;
use App\Models\Designer;
use App\Services\DesignerService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


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
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
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
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.designers.create', ['model' => new Designer()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DesignerRequest $request
     * @return RedirectResponse
     */
    public function store(DesignerRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->create($request->validated());
        return redirect()->route('admin.designers.index')->with('msg', __('global.messages.crt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Designer $designer
     * @return View|RedirectResponse
     */
    public function edit(Designer $designer): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.designers.edit', ['model' => $designer]);
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
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->update($data, $designer);
        return redirect()->route('admin.designers.index')->with('msg', __('global.messages.upd'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Designer $designer
     * @return RedirectResponse
     */
    public function destroy(Designer $designer): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        try {
            $this->service->delete($designer);
            return redirect()->route('admin.designers.index')->with('msg', __('global.messages.del'));
        } catch (Exception $ex) {
            return redirect()->route('admin.designers.index')
                ->with('msg', __('admin.designer.del_title'))
                ->with('msg_type', 'info');
        }
    }
}
