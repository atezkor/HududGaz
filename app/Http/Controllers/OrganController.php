<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganRequest;
use App\Models\Organ;
use App\Repositories\DistrictRepository;
use App\Services\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;


class OrganController extends Controller {

    private Service $service;

    private DistrictRepository $districtRepository;


    public function __construct(DistrictRepository $districtRepository) {
        $this->service = new Service(new Organ());
        $this->districtRepository = $districtRepository;
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = Organ::all();
        return view('admin.organs.index', ['models' => $models]);
    }

    public function create(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.organs.create', [
            'model' => new Organ(), 'districts' => $this->districtRepository->all()
        ]);
    }

    public function store(OrganRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        try {
            $this->service->create($data);
            return redirect()->route('admin.organs.index')->with('msg', __('global.messages.crt'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function edit(Organ $organ): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.organs.edit', [
            'model' => $organ, 'districts' => $this->districtRepository->all()
        ]);
    }

    public function update(OrganRequest $request, Organ $organ): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        try {
            $this->service->update($data, $organ);
            return redirect()->route('admin.organs.index')->with('msg', __('global.messages.upd'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
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
