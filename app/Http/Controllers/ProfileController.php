<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ProfileController extends Controller {

    private UserService $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function edit(int $userId): View|RedirectResponse {
        try {
            $this->authorize('edit_profile');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $user = request()->user();
        if ($user->id != $userId)
            return redirect()->back();

        return view('profile', [
            'model' => $user
        ]);
    }

    public function update(ProfileRequest $request, User $user): RedirectResponse {
        try {
            $this->authorize('edit_profile');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        try {
            $data = $request->validated();
            $this->service->update($data, $user);
            return redirect()->route('dashboard');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
