<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Status;
use App\Services\Service;
use App\Http\Requests\StatusRequest;


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
