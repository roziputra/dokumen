<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
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
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            $permissions = Role::getPermissions($user->id);
            if (!$permissions) {
                return false;
            }

            $this->permissions = $permissions;
        });

        $permissionKeys = array_keys(Role::getPermissionMapping());

        foreach ($permissionKeys as $permissionKey) {
            Gate::define($permissionKey, function ($user) use ($permissionKey) {
                switch ($user->type) {
                    case User::TYPE_ADMIN:
                        $userPermissions = Role::getAdminPermissionMapping();
                        break;
                    case User::TYPE_USER:
                        $userPermissions = Role::getUserPermissionMapping();
                        break;
                    default:
                        $userPermissions = [];
                }

                if (!isset($userPermissions[$permissionKey])) {
                    return false;
                }

                return $this->permissions[$permissionKey] ?? false;
            });
        }
    }
}
