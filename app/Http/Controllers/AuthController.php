<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Utilities\CryptoHash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class AuthController extends Controller {
    use CryptoHash;

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
        /* @var User $user */
        $credentials = $request->validated();
        $user = User::query()
            ->where('username', '=', $credentials['username'])
            ->first();

        if ($user === null)
            return redirect()->route('login');

        if (!$this->compare($credentials['password'], $user->password))
            return redirect()->route('login');

        auth()->login($user); // auth()->attempt($data, true)
        return redirect()->route('dashboard');
    }

    public function dashboard(): RedirectResponse {
        /* @var User $user */
        $user = request()->user();
        if ($user == null)
            return redirect()->route('login');

        switch ($user->role_id) {
            case User::ROLE_ADMIN:
                return redirect('/admin');
            case User::TECHNIC:
                return redirect('/technic');
            case User::ORGAN:
                return redirect('/district');
            case User::DESIGNER:
                return redirect('/designer');
            case User::ENGINEER:
                return redirect('/engineer');
            case User::MOUNTER:
                return redirect('/mounter');
            case User::DIRECTOR:
                return redirect('/director');
        }

        auth()->logout();
        return redirect()->route('login');
    }
}
