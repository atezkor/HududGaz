<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
