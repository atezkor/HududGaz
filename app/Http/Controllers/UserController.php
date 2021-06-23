<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Region;
use App\Models\Designer;
use App\Models\Mounter;
use App\Http\Requests\UserRequest;
use App\Services\UserService;


class UserController extends Controller {

    private UserService $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('show', UserController::class);
        } catch (AuthorizationException) {
            // return redirect('/logout');
        }

        $models = User::query()->where('role', '<>', 1)->get();
        return view('admin.users.index', ['models' => $models]);
    }

    public function create(): View|RedirectResponse {
        return view('admin.users.form', ['model' => new User(),
            'action' => route('admin.users.store'), 'method' => 'POST']);
    }


    public function checkFirmOrOrgan(int $role): Collection|null {
        switch ($role) {
            case 3:
                return Region::query()->pluck('org_name', 'id');
            case 4:
                return Designer::query()->pluck('org_name', 'id');
            case 6:
                return Mounter::query()->pluck('short_name', 'id');
        }

        return null;
    }

    public function store(UserRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user): View|RedirectResponse {
        return view('admin.users.form', ['model' => $user,
            'action' => route('admin.users.update', ['user' => $user]), 'method' => 'PUT']);
    }

    public function update(UserRequest $request, User $user): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $user);
        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user): RedirectResponse {
        $this->service->delete($user);
        return redirect()->route('admin.users.index');
    }
}
