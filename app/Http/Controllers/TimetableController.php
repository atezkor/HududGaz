<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimetableController extends Controller {
    public function index(): View|RedirectResponse {
        return view('admin.timetable');
    }

    public function update(Request $request): RedirectResponse {
        return redirect()->route($request);
    }
}
