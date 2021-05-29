<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DistrictRequest;
use App\Services\DistrictService;
use App\Models\Region;

class RegionController extends Controller {

    private DistrictService $service;

    public function __construct(DistrictService $service) {
        $this->service = $service;
    }

    public function index(): View|RedirectResponse {
        $models = Region::all();
        return view('admin.regions.index', ['models' => $models]);
    }

    public function create(): View|RedirectResponse {
        $model = new Region();
        return view('admin.regions.form', ['action' => route('admin.regions.store'), 'method' => 'POST',
            'model' => $model, 'regions' => districts()]);
    }

    public function store(DistrictRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.regions.index');
    }

    public function edit(Region $region): View|RedirectResponse {
        return view('admin.regions.form', ['action' => route('admin.regions.update', ['region' => $region]),
            'method' => 'PUT', 'model' => $region, 'regions' => districts()]);
    }

    public function update(DistrictRequest $request, Region $region): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $region);
        return redirect()->route('admin.regions.index');
    }

    public function destroy(Region $region): RedirectResponse {
        $this->service->delete($region);
        return redirect()->route('admin.regions.index');
    }
}
