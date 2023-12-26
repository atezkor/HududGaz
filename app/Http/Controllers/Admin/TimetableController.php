<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Services\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class TimetableController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Timetable());
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = Timetable::all();
        $holidays = $models->where('type', Timetable::TYPE_HOLIDAY);
        $extraDays = $models->where('type', Timetable::TYPE_EXTRA_WORK_DAY);
//        dd($models);

        return view('admin.timetable.index', compact('holidays', 'extraDays'));
    }

    public function create(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.timetable.form', [
            'model' => new Timetable(),
            'action' => route('admin.timetables.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->all();
        $this->service->create($data);
        return redirect()->route('admin.timetables.index');
    }

    public function edit(Timetable $timetable): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.timetable.form', [
            'model' => $timetable,
            'method' => 'PUT',
            'action' => route('admin.timetables.update', $timetable)
        ]);
    }

    public function update(Request $request, Timetable $timetable): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->all();
        $this->service->update($data, $timetable);
        return redirect()->route('admin.timetables.index');
    }

    public function destroy(Timetable $timetable): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->delete($timetable);
        return redirect()->route('admin.timetables.index');
    }
}
