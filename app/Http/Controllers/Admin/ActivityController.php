<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Services\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ActivityController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Activity());
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = Activity::all();
        return view('admin.activities', ['models' => $models]);
    }

    public function store(ActivityRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.activities.index')->with('msg', __('global.messages.crt'));
    }

    public function update(ActivityRequest $request, Activity $activity_type): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->update($data, $activity_type);
        return redirect()->route('admin.activities.index')->with('msg', __('global.messages.upd'));
    }

    public function destroy(Activity $activity_type): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/')->route('login');
        }

        $this->service->delete($activity_type);
        return redirect()->route('admin.activities.index')->with('msg', __('global.messages.del'));
    }
}
