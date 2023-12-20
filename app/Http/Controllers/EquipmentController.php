<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentRequest;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Services\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class EquipmentController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new EquipmentType());
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

        $models = EquipmentType::all();
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

        return redirect()->route('admin.equipment-types.index')->with('msg', __('global.messages.crt'));
    }



    /**
     * Display the specified resource.
     *
     * @param EquipmentType $equipment
     * @return View|RedirectResponse
     */
    public function show(EquipmentType $equipment): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = $equipment->types()->get();
        return view('admin.equipments.types', ['equipment' => $equipment, 'method' => 'PUT', 'models' => $models]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentRequest $request
     * @param EquipmentType $equipmentType
     * @return RedirectResponse
     */
    public function update(EquipmentRequest $request, EquipmentType $equipmentType): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();

        $this->service->update($data, $equipmentType);
        return redirect()->back()->with('msg', __('global.messages.upd'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EquipmentType $equipmentType
     * @return RedirectResponse
     */
    public function destroy(EquipmentType $equipmentType): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        // admin.equipment.del_info
        $this->service->delete($equipmentType);
        return redirect()->back()->with('msg', __('global.messages.del'));
    }

    /**
     * @param EquipmentRequest $request
     * @param EquipmentType $equipment
     * @return RedirectResponse
     */
    public function add(EquipmentRequest $request, EquipmentType $equipment): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $data['equipment_id'] = $equipment->id;
        $this->service->update($data, new Equipment());

        return redirect()->back()->with('msg', __('global.messages.crt'));
    }

    /**
     * @param EquipmentRequest $request
     * @param Equipment $type
     * @return RedirectResponse
     */
    public function renew(EquipmentRequest $request, Equipment $type): RedirectResponse {
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
     * @param Equipment $type
     * @return RedirectResponse
     */
    public function remove(Equipment $type): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $type->delete();
        return redirect()->back()->with('msg', __('global.messages.del'));
    }
}
