<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //======================================================================
        // Authorization Based On Action
        //======================================================================

        /*
         * 1. Action names use kebab-case.
         * 2. Separate actions as detailed as possible. For example, "edit-tag"
         *    and "create-tag" are different actions.
         * 3. Always use whitelist logic.
         */

        // User

        Gate::define('set-user-role', function ($user, $target_user) {
            // Admin cannot set roles of other admins
            return $user->role === 'admin' && $target_user->role !== 'admin';
        });

        Gate::define('unset-user-role', function ($user, $target_user) {
            if ($user->id === $target_user->id) {
                return true; // User can unset own role
            } elseif ($user->role === 'admin' && $target_user->role !== 'admin') {
                return true; // Admin can unset roles of users but not other admins
            } else {
                return false;
            }
        });

        Gate::define('delete-user', function ($user, $target_user) {
            // Admins and editors must be deleted through command line.
            if ($target_user->role === 'admin' || $target_user->role === 'editor') {
                return false;
            }

            // Admins can delete normal users.
            if ($user->role === 'admin') {
                return true;
            }

            // Normal users can delete themselves.
            if ($user->id === $target_user->id) {
                return true;
            }

            return false;
        });


        // Designer page

        Gate::define('create-designer', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->designers()->count() === 0;
        });

        Gate::define('edit-designer', function ($user, $designer) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $designer->user_id;
        });

        Gate::define('transfer-designer', function ($user, $designer) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $designer->user_id;
        });

        Gate::define('delete-designer', function ($user, $designer) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $designer->user_id;
        });

        Gate::define('editor-pick', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });


        // Design page

        Gate::define('edit-design', function ($user, $design) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $design->user_id || $user->id === $design->designer->user_id;
        });

        Gate::define('transfer-design', function ($user, $design) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $design->user_id || $user->id === $design->designer->user_id;
        });

        Gate::define('delete-design', function ($user, $design) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $design->user_id || $user->id === $design->designer->user_id;
        });


        // Place page

        Gate::define('edit-place', function ($user, $place) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $place->user_id;
        });

        Gate::define('transfer-place', function ($user, $place) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $place->user_id;
        });

        Gate::define('delete-place', function ($user, $place) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $place->user_id;
        });


        // Story page

        Gate::define('edit-story', function ($user, $story) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $story->user_id;
        });

        Gate::define('transfer-story', function ($user, $story) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $story->user_id;
        });

        Gate::define('delete-story', function ($user, $story) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $story->user_id;
        });


        // Image

        Gate::define('delete-image', function ($user, $image) {
            if ( $user->role === 'admin' || $user->role === 'editor' ) {
                return true;
            }

            if ( $user->id === $image->user_id ) {
                return true;
            }

            if ( !count($image->parent) ) {
                return false;
            }

            if ( $image->parent->user_id === $user->id ) {
                return true;
            }

            if ( $image->parent_type === 'design' && count($image->parent->designer)
                && $image->parent->designer->user_id === $user->id) {
                return true;
            }

            return false;
        });


        // City page

        Gate::define('create-city', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        Gate::define('edit-city', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        Gate::define('delete-city', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });


        // Country page

        Gate::define('create-country', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        Gate::define('edit-country', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        Gate::define('delete-country', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });


        // Tag page

        Gate::define('create-tag', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        Gate::define('edit-tag', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        Gate::define('delete-tag', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });
    }
}
