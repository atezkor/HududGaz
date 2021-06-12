<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Services\EquipmentService;
use App\Http\Requests\EquipmentRequest;

class EquipmentController extends Controller {

    protected EquipmentService $service;

    public function __construct(EquipmentService $service) {
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View {
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
        $data = $request->validated();
        $this->service->create($data);

        return redirect()->route('admin.equipments.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentRequest $request
     * @param Equipment $equipment
     * @return RedirectResponse
     */
    public function update(EquipmentRequest $request, Equipment $equipment): RedirectResponse {
        $data = $request->validated();

        $this->service->update($data, $equipment);
        return redirect()->route('admin.equipments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Equipment $equipment
     * @return RedirectResponse
     */
    public function destroy(Equipment $equipment): RedirectResponse {
        $this->service->delete($equipment);
        return redirect()->route('admin.equipments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Equipment $equipment
     * @return View
     */
    public function show(Equipment $equipment): View {
        $models = $equipment->types()->get();
        return view('admin.equipments.types', ['equipment' => $equipment, 'method' => 'PUT', 'models' => $models]);
    }

    /**
     * @param EquipmentRequest $request
     * @param Equipment $equipment
     * @return RedirectResponse
     */
    public function add(EquipmentRequest $request, Equipment $equipment): RedirectResponse {
        $data = $request->validated();
        $data['equipment_id'] = $equipment->getAttribute('id');
        $this->service->typeChange(new EquipmentType(), $data);

        return redirect()->route('admin.equip_type', ['equipment' => $equipment->getAttribute('id')]);
    }

    /**
     * @param EquipmentRequest $request
     * @param Equipment $equipment
     * @param EquipmentType $type
     * @return RedirectResponse
     */
    public function renew(EquipmentRequest $request, Equipment $equipment, EquipmentType $type): RedirectResponse {
        $data = $request->validated();
        $data['equipment_id'] = $equipment->getAttribute('id');

        $this->service->typeChange($type, $data);
        return redirect()->route('admin.equip_type', ['equipment' => $equipment->getAttribute('id')]);
    }

    /**
     * @param EquipmentType $type
     * @return RedirectResponse
     */
    public function del(EquipmentType $type): RedirectResponse {
        $type->delete();
        return redirect()->route('admin.equip_type', ['equipment' => $type->getAttribute('equipment_id')]);
    }
}
