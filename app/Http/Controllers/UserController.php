<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller {

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('show', UserController::class);
        } catch (AuthorizationException) {
            // return redirect('/logout');
        }

        $models = User::query()->where('role_id', '<>', 1)->get();
        return view('admin.users.index', ['models' => $models]);
    }
}
