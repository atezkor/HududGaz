<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;
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
        file_put_contents('t.txt', $user->createToken('auth_token')->plainTextToken);
        return redirect()->route('dashboard');
    }

    private function checkPass($pass, $pass_database): bool {
        return HASH::check($pass, $pass_database);
    }

    private function getLastToken($user) {
        $token = $user->tokens()->orderByDesc('id')->first('token');
        return new NewAccessToken($token, $token->getKey().'|'.$token->plainTextToken);
    }
}
