<?php

namespace App\Http\Controllers;

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

    public function edit(User $user): View {
        return view('profile', ['model' => $user, 'action' => route('profile.update', ['user' => $user])]);
    }

    public function update(ProfileRequest $request, User $user): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $user);
        return redirect()->route('dashboard');
    }
}
