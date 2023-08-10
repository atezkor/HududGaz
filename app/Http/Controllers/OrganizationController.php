<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Models\Organization;


class OrganizationController extends Controller {

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $model = Organization::Data();
        return view('admin.settings', ['model' => $model]);
    }

    public function set(Request $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $organ = new Organization();
        $organ->setData($request->all());
        Cache::put('organization', $organ);

        return redirect()->route('admin.settings');
    }
}
