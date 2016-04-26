<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
            if (!Auth::check()) {
                return false;
            }

            $user = Auth::user();

            if ($user->hasRole('admin') || $user->hasRole('editor')) {
                return true;
            }

            return $user->id === $page_model->user_id;
        });

        $gate->define('translate', function ($user, $page_model) {
            if (!Auth::check()) {
                return false;
            }

            $user = Auth::user();

            if ($user->hasRole('admin') || $user->hasRole('editor') || $user->hasRole('translator')) {
                return true;
            }

            return $user->id === $page_model->user_id;
        });
    }
}
