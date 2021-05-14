<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function login(): View|RedirectResponse {
        if (auth()->user())
            return redirect()->route('dashboard');

        return view('login');
    }

    /*
     * This function for logout
    */
    public function logout(): RedirectResponse {
        auth()->logout();
        return redirect('/');
    }

    public function auth(UserRequest $request): RedirectResponse {
        $data = $request->validated();
        $user = User::query()->where('email', '=', $data['email'])->get()->first();

        if ($user === null)
            return redirect()->route('login');

        if (!$this->checkPass($data['password'], $user->password))
            return redirect()->route('login');

        auth()->login($user);
        return redirect()->route('login');
    }

    public function store(UserRequest $request): RedirectResponse {
        if (auth()->user())
            return redirect('/');

        $data = $request->validated();

        $user = new User();
        $data['password'] = $this->hashPass($data['password']);
        $user->fill($data);
        $user->save();

        return redirect()->route('login');
    }

    public function create(): View|RedirectResponse {
        if (auth()->user())
            return redirect()->route('dashboard');

        return view('register');
    }

    private function hashPass($pass): string {
        return Hash::make($pass);
    }

    private function checkPass($pass, $pass_database): bool {
        return HASH::check($pass, $pass_database);
    }
}
