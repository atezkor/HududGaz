<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;


class OrganizationController extends Controller {
    public function index(): View {
        $model = Organization::Data();
        return view('admin.settings', ['model' => $model]);
    }

    public function set(Request $request): RedirectResponse {
        $organ = new Organization();
        $organ->setData($request->all());
        Cache::put('organization', $organ);

        return redirect()->route('admin.settings');
    }
}
