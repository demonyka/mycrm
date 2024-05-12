<?php

namespace App\Providers;

use App\Models\Staff\Permission;
use App\Models\Staff\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->permission, function (User $user) use ($permission) {
                return $user->hasPermission($permission->permission);
            });
        }
    }
}
