<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Models\Status;
use App\Services\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class StatusController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Status());
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

        $models = Status::all();
        return view('admin.statuses.index', ['models' => $models]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Status $status
     * @return View|RedirectResponse
     */
    public function edit(Status $status): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.statuses.form', [
            'action' => route('admin.statuses.update', ['status' => $status]),
            'model' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StatusRequest $request
     * @param Status $status
     * @return RedirectResponse
     */
    public function update(StatusRequest $request, Status $status): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->update($data, $status);
        return redirect()->route('admin.statuses.index')->with('msg', __('global.messages.upd'));
    }
}
