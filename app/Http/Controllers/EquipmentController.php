<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentRequest;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Services\EquipmentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EquipmentController extends Controller {

    protected EquipmentService $service;

    public function __construct(EquipmentService $service) {
        $this->service = $service;
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application {
        $models = Equipment::all();
        return view('admin.equipments.index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application {
        return view('admin.equipments.form', ['action' => route('admin.equipments.store'),
            'method' => 'POST', 'model' => new Equipment()]);
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
     * Show the form for editing the specified resource.
     *
     * @param Equipment $equipment
     * @return Application|Factory|View
     */
    public function edit(Equipment $equipment): View|Factory|Application {
        return view('admin.equipments.form', ['action' => route('admin.equipments.update', ['equipment' => $equipment]),
            'method' => 'PUT', 'model' => $equipment]);
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
     * @return Application|Factory|View
     */
    public function show(Equipment $equipment): View|Factory|Application {
        $models = $equipment->types()->get();
        return view('admin.equipments.types', ['equipment' => $equipment, 'method' => 'PUT', 'models' => $models]);
    }

    /**
     * @param Request $request
     * @param Equipment $equipment
     * @return RedirectResponse
     */
    public function add(Request $request, Equipment $equipment): RedirectResponse {
        $data = [
            'equipment_id' => $equipment->getAttribute('id'),
            'type' => $request->get('type'),
            'order' => $request->get('order'),
        ];

        $this->service->typeChange(new EquipmentType(), $data);
        return redirect()->route('admin.equip_type', ['equipment' => $equipment->getAttribute('id')]);
    }

    /**
     * @param Request $request
     * @param Equipment $equipment
     * @param EquipmentType $type
     * @return RedirectResponse
     */
    public function renew(Request $request, Equipment $equipment, EquipmentType $type): RedirectResponse {
        $data = [
            'equipment_id' => $equipment->getAttribute('id'),
            'type' => $request->get('type'),
            'order' => $request->get('order'),
        ];

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
