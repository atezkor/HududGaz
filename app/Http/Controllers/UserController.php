<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class UserController extends Controller {

    public function index(): View|Factory|RedirectResponse|Application {
//        try {
//            $this->authorize('browse_user');
//        } catch (AuthorizationException) {
//            return redirect()->route('dashboard');
//        }
        App::setLocale('uz');
//        session()->put('locale', 'uz');

        $models = User::query()->where('role_id', '<>', 1)->get();
        return view('admin.users.index', ['models' => $models]);
    }
}
