<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Services\Service;
use App\Http\Requests\EquipmentRequest;


class EquipmentController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Equipment());
    }

    /**
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = Equipment::all();
        return view('admin.equipments.index', ['models' => $models]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EquipmentRequest $request
     * @return RedirectResponse
     */
    public function store(EquipmentRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->create($data);

        return redirect()->route('admin.equipments.index')->with('msg', __('global.messages.crt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentRequest $request
     * @param Equipment $equipment
     * @return RedirectResponse
     */
    public function update(EquipmentRequest $request, Equipment $equipment): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();

        $this->service->update($data, $equipment);
        return redirect()->back()->with('msg', __('global.messages.upd'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Equipment $equipment
     * @return RedirectResponse
     */
    public function destroy(Equipment $equipment): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        if ($equipment->checkStatic()) {
            return redirect()->back()->with('msg', __('admin.equipment.del_info'))->with('msg_type', 'info');
        }

        $this->service->delete($equipment);
        return redirect()->back()->with('msg', __('global.messages.del'));
    }

    /**
     * Display the specified resource.
     *
     * @param Equipment $equipment
     * @return View|RedirectResponse
     */
    public function show(Equipment $equipment): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = $equipment->types()->get();
        return view('admin.equipments.types', ['equipment' => $equipment, 'method' => 'PUT', 'models' => $models]);
    }

    /**
     * @param EquipmentRequest $request
     * @param Equipment $equipment
     * @return RedirectResponse
     */
    public function add(EquipmentRequest $request, Equipment $equipment): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $data['equipment_id'] = $equipment->id;
        $this->service->update($data, new EquipmentType());

        return redirect()->back()->with('msg', __('global.messages.crt'));
    }

    /**
     * @param EquipmentRequest $request
     * @param EquipmentType $type
     * @return RedirectResponse
     */
    public function renew(EquipmentRequest $request, EquipmentType $type): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->update($data, $type);

        return redirect()->back()->with('msg', __('global.messages.upd'));
    }

    /**
     * @param EquipmentType $type
     * @return RedirectResponse
     */
    public function remove(EquipmentType $type): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $type->delete();
        return redirect()->back()->with('msg', __('global.messages.del'));
    }
}
