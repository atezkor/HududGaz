<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TechnicController extends Controller {
    public function index(): View|RedirectResponse {
        $models = Recommendation::query()->where('status', '=', 2)->get();
        return view('technic.recommends', ['models' => $models]);
    }
}
