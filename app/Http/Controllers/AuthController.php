<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthRequest;
use App\Models\User;


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

    public function entry(AuthRequest $request): RedirectResponse {
        $data = $request->validated();
        $user = User::query()->where('username', '=', $data['username'])->first();

        if ($user === null)
            return redirect()->route('login');

        if (!$this->checkPass($data['password'], $user->password))
            return redirect()->route('login');

        auth()->login($user); // auth()->attempt($data, true)
        return redirect()->route('dashboard');
    }

    private function checkPass($pass, $pass_database): bool {
        return HASH::check($pass, $pass_database);
    }

    public function redirect(): RedirectResponse {
        $user = request()->user();
        if ($user == null)
            return redirect()->route('login');

        $role = $user->role;
        switch ($role) {
            case 1: return redirect('/admin');
            case 2: return redirect('/technic');
            case 3: return redirect('/district');
            case 4: return redirect('/designer');
            case 5: return redirect('/engineer');
            case 6: return redirect('/mounter');
            case 7: return redirect('/director');
        }

        auth()->logout();
        return redirect()->route('login');
    }
}
