<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller {

    private UserService $service;
    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function edit(User $user): View|RedirectResponse {
        try {
            $this->authorize('edit_profile');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        return view('profile', ['model' => $user, 'action' => route('profile.update', ['user' => $user])]);
    }

    public function update(ProfileRequest $request, User $user): RedirectResponse {
        try {
            $this->authorize('edit_profile');
        } catch (AuthorizationException) {
            return redirect()->route('logout');
        }

        $data = $request->validated();
        $this->service->update($data, $user);
        return redirect()->route('dashboard');
    }
}
