<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistrictRequest;
use App\Models\Base;
use App\Models\Region;
use App\Services\DistrictService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegionController extends Controller {

    private DistrictService $service;

    public function __construct(DistrictService $service) {
        $this->service = $service;
    }

    public function index(): View|RedirectResponse {
        app()->setLocale('uz');

        $models = Region::all();
        return view('admin.regions.index', ['models' => $models]);
    }

    public function create(): View|RedirectResponse {
        app()->setLocale('uz');

        $model = new Region();
        return view('admin.regions.form', ['action' => route('admin.regions.store'), 'method' => 'POST',
            'model' => $model, 'regions' => Base::districts()]);
    }

    public function store(DistrictRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.regions.index');
    }

    public function edit(Region $region): View|RedirectResponse {
        app()->setLocale('uz');

        return view('admin.regions.form', ['action' => route('admin.regions.update', ['region' => $region]),
            'method' => 'PUT', 'model' => $region, 'regions' => Base::districts()]);
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
