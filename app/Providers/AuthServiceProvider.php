<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        $gates = Permission::query()->get(['name', 'role']);
        foreach ($gates as $gate) {
            Gate::define($gate->name, function(User $user) use ($gates, $gate) {
                return count($gates->where('name', $gate->name)->where('role', $user->role)); // 0 | 1
            });
        }
    }
}
