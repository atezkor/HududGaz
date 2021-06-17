<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MontageController extends Controller {

    public function index(): View {
        return view('installer.index');
    }
}
