<?php

namespace App\Providers;

use App\Models\Staff\Permission;
use App\Models\Staff\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('permissions')) {
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                Gate::define($permission->permission, function (User $user) use ($permission) {
                    return $user->hasPermission($permission->permission) ? Response::allow() : Response::deny('Необходимо право "' . $permission->name . '"');
                });
            }
        }
    }
}
