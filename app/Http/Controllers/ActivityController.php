<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Activity;
use App\Http\Requests\ActivityRequest;
use App\Services\Service;

class ActivityController extends Controller {
    private Service $service;

    public function __construct() {
        $this->service = new Service(new Activity());
    }

    public function index(): View|RedirectResponse {
        $models = Activity::all();
        return view('admin.activities', ['models' => $models]);
    }

    public function store(ActivityRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.activities.index');
    }

    public function update(ActivityRequest $request, Activity $activity_type): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $activity_type);
        return redirect()->route('admin.activities.index');
    }

    public function destroy(Activity $activity_type): RedirectResponse {
        $this->service->delete($activity_type);
        return redirect()->route('admin.activities.index');
    }
}
