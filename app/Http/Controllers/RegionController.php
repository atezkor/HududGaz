<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Organ;
use App\Services\Service;
use App\Http\Requests\DistrictRequest;


class RegionController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Organ());
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = Organ::all();
        return view('admin.regions.index', ['models' => $models]);
    }

    public function create(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $model = new Organ();
        return view('admin.regions.form', [
            'action' => route('admin.organs.store'),
            'method' => 'POST',
            'model' => $model, 'districts' => districts()
        ]);
    }

    public function store(DistrictRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.organs.index')
            ->with('msg', __('global.messages.crt'));
    }

    public function edit(Organ $organ): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.regions.form', [
            'action' => route('admin.organs.update', ['organ' => $organ]),
            'method' => 'PUT',
            'model' => $organ, 'districts' => districts()
        ]);
    }

    public function update(DistrictRequest $request, Organ $organ): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->update($data, $organ);
        return redirect()->route('admin.organs.index')->with('msg', __('global.messages.upd'));
    }

    public function destroy(Organ $organ): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->delete($organ);
        return redirect()->route('admin.organs.index')->with('msg', __('global.messages.del'));
    }
}
