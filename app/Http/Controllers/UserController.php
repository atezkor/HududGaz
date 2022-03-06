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
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
             return redirect('/');
        }

        $models = User::query()->where('role', '<>', 1)->get();
        return view('admin.users.index', ['models' => $models, 'show' => true]);
    }

    public function create(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.users.form', ['model' => new User(),
            'action' => route('admin.users.store'), 'method' => 'POST']);
    }


    public function checkRole(int $role): Collection {
        switch ($role) {
            case User::REGION:
                return Region::query()->pluck('org_name', 'id');
            case User::DESIGNER:
                return Designer::query()->pluck('org_name', 'id');
            case User::MOUNTER:
                return Mounter::query()->pluck('short_name', 'id');
        }

        return new Collection();
    }

    public function store(UserRequest $request): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('admin.users.index')->with('msg', __('global.messages.crt'));
    }

    public function edit(User $user): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.users.form', ['model' => $user,
            'action' => route('admin.users.update', ['user' => $user]), 'method' => 'PUT']);
    }

    public function update(UserRequest $request, User $user): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $data = $request->validated();
        $this->service->update($data, $user);
        return redirect()->route('admin.users.index')->with('msg', __('global.messages.upd'));
    }

    public function destroy(User $user): RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $this->service->delete($user);
        return redirect()->route('admin.users.index')->with('msg', __('global.messages.del'));
    }
}
