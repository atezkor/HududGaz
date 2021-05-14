<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Models\Status;
use App\Services\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
        app()->setLocale('uz');

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
        app()->setLocale('uz');

        return view('admin.statuses.form', ['action' => route('admin.statuses.update', ['status' => $status]),
            'model' => $status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StatusRequest $request
     * @param Status $status
     * @return RedirectResponse
     */
    public function update(StatusRequest $request, Status $status): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $status);
        return redirect()->route('admin.statuses.index');
    }
}
