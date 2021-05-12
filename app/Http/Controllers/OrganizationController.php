<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrganizationController extends Controller {
    public function index(): View {
        app()->setLocale('uz');
        return view('admin.settings');
    }

    public function set(): RedirectResponse {
        return redirect()->route('admin.settings');
    }
}
