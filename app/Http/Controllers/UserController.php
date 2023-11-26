<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Designer;
use App\Models\Mounter;
use App\Models\Organ;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;


class UserController extends Controller {

    private UserService $service;

    private UserRepository $repository;

    public function __construct(UserService $service, UserRepository $repository) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        $models = $this->repository->users();
        return view('admin.users.index', [
            'models' => $models,
            'roles' => $this->service->roles(),
            'branch' => getName()
        ]);
    }

    public function create(): View|RedirectResponse {
        try {
            $this->authorize('crud_admin');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('admin.users.create', [
            'model' => new User(),
            'roles' => $this->service->roles()
        ]);
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

        return view('admin.users.edit', [
            'model' => $user,
            'roles' => $this->service->roles()
        ]);
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

    public function checkRole(int $role): Collection {
        switch ($role) {
            case User::ORGAN:
                return Organ::query()->pluck('org_name', 'id');
            case User::DESIGNER:
                return Designer::query()->pluck('org_name', 'id');
            case User::MOUNTER:
                return Mounter::query()->pluck('short_name', 'id');
        }

        return new Collection();
    }
}
