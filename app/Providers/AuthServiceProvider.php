<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('edit-page', function ($user, $page_model) {
            if ($user->hasRole('admin') || $user->hasRole('editor')) {
                return true;
            }

            return $user->id === $page_model->user_id;
        });

        $gate->define('translate-page', function ($user, $page_model) {
            if ($user->hasRole('admin') || $user->hasRole('editor') || $user->hasRole('translator')) {
                return true;
            }

            return $user->id === $page_model->user_id;
        });

        // Action: create tag
        // Roles: admin, editor
        $gate->define('create-tag', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        // Action: edit tag
        // Roles: admin, editor
        $gate->define('edit-tag', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        // Action: delete tag
        // Roles: admin, editor
        $gate->define('delete-tag', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });
    }
}
