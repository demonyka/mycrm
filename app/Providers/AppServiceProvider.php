<?php

namespace App\Providers;

use App\Models\Staff\Permission;
use App\Models\Staff\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Schema;

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
        if (Schema::hasTable('permissions')) {
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                Gate::define($permission->permission, function (User $user) use ($permission) {
                    \Log::debug($permission);
                    return $user->hasPermission($permission->permission) ? Response::allow() : Response::deny('Необходимо право "' . $permission->name . '"');
                });
            }
        }
    }
}
