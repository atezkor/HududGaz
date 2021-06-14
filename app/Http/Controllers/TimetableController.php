<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Timetable;
use App\Services\Service;

class TimetableController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Timetable());
    }

    public function index(): View|RedirectResponse {
        $models = Timetable::all();
        $holidays = $models->where('type', 1);
        $extra_days = $models->where('type', 2);
        return view('admin.table.index', ['holidays' => $holidays, 'extra_days' => $extra_days]);
    }

    public function create(): View {
        return view('admin.table.form', ['model' => new Timetable(),
            'action' => route('admin.timetable.store'), 'method' => 'POST']);
    }

    public function store(Request $request): RedirectResponse {
        $data = $request->all();
        $data['start'] = $data['interval'];
        $data['end'] = $data['interval'];
        $this->service->create($data);
        return redirect()->route('admin.timetable.index');
    }

    public function edit(Timetable $timetable): View {
        return view('admin.table.form', ['model' => $timetable, 'method' => 'PUT',
            'action' => route('admin.timetable.update', ['timetable'=> $timetable])]);
    }

    public function update(Request $request, Timetable $timetable): RedirectResponse {
        $data = $request->all();
        $this->service->update($data, $timetable);
        return redirect()->route('admin.timetable.index');
    }

    public function destroy(Timetable $timetable): RedirectResponse {
        $this->service->delete($timetable);
        return redirect()->route('admin.timetable.index');
    }
}
