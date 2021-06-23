<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Region;
use App\Services\Service;
use App\Http\Requests\DistrictRequest;

class RegionController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Region());
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $models = Region::all();
        return view('admin.regions.index', ['models' => $models]);
    }

    public function create(): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $model = new Region();
        return view('admin.regions.form', ['action' => route('admin.organs.store'), 'method' => 'POST',
            'model' => $model, 'districts' => districts()]);
    }

    public function store(DistrictRequest $request): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.organs.index');
    }

    public function edit(Region $organ): View|RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        return view('admin.regions.form', ['action' => route('admin.organs.update', ['organ' => $organ]),
            'method' => 'PUT', 'model' => $organ, 'districts' => districts()]);
    }

    public function update(DistrictRequest $request, Region $organ): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $data = $request->validated();
        $this->service->update($data, $organ);
        return redirect()->route('admin.organs.index');
    }

    public function destroy(Region $organ): RedirectResponse {
        try {
            $this->authorize('be_admin');
        } catch (AuthorizationException) {
            return redirect()->route('login');
        }

        $this->service->delete($organ);
        return redirect()->route('admin.organs.index');
    }
}
