<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MounterRequest;
use App\Models\Mounter;
use App\Repositories\DistrictRepository;
use App\Services\Mounter\MounterService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class MounterController extends Controller {

    private MounterService $service;

    private DistrictRepository $districtRepository;

    public function __construct(MounterService $service, DistrictRepository $districtRepository) {
        $this->service = $service;
        $this->districtRepository = $districtRepository;
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

        return view('admin.mounters.index', ['models' => Mounter::all()]);
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

        $model = new Mounter();
        return view('admin.mounters.create', ['model' => $model, 'districts' => $this->districtRepository->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MounterRequest $request
     * @return RedirectResponse
     */
    public function store(MounterRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->create($request->validated());
        return redirect()->route('admin.mounters.index')->with('msg', __('global.messages.crt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Mounter $mounter
     * @return View|RedirectResponse
     */
    public function edit(Mounter $mounter): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.mounters.edit', [
            'model' => $mounter,
            'districts' => $this->districtRepository->all()
        ]);
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
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->update($data, $mounter);
        return redirect()->route('admin.mounters.index')->with('msg', __('global.messages.upd'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Mounter $mounter
     * @return RedirectResponse
     */
    public function destroy(Mounter $mounter): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($mounter->montages)
            return redirect()->route('admin.designers.index')->with('msg', __('admin.mounter.del_title'))->with('msg_type', 'info');

        $this->service->delete($mounter);
        return redirect()->route('admin.mounters.index')->with('msg', __('global.messages.del'));
    }

    /**
     * This view for only director
     * @return View|RedirectResponse
     */
    public function director(): View|RedirectResponse {
        try {
            $this->authorize('res_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('director.mounters', [
            'models' => Mounter::all()
        ]);
    }
}
