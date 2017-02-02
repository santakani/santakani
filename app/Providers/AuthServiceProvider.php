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

        $gate->define('set-user-role', function ($user, $target_user) {
            // Admin cannot set roles of other admins
            return $user->role === 'admin' && $target_user->role !== 'admin';
        });

        $gate->define('unset-user-role', function ($user, $target_user) {
            if ($user->id === $target_user->id) {
                return true; // User can unset own role
            } elseif ($user->role === 'admin' && $target_user->role !== 'admin') {
                return true; // Admin can unset roles of users but not other admins
            } else {
                return false;
            }
        });

        $gate->define('delete-user', function ($user, $target_user) {
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

        $gate->define('create-designer', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->designers()->count() === 0;
        });

        $gate->define('edit-designer', function ($user, $designer) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $designer->user_id;
        });

        $gate->define('transfer-designer', function ($user, $designer) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $designer->user_id;
        });

        $gate->define('delete-designer', function ($user, $designer) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $designer->user_id;
        });


        // Design page

        $gate->define('edit-design', function ($user, $design) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $design->user_id || $user->id === $design->designer->user_id;
        });

        $gate->define('transfer-design', function ($user, $design) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $design->user_id || $user->id === $design->designer->user_id;
        });

        $gate->define('delete-design', function ($user, $design) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $design->user_id || $user->id === $design->designer->user_id;
        });


        // Place page

        $gate->define('edit-place', function ($user, $place) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $place->user_id;
        });

        $gate->define('transfer-place', function ($user, $place) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $place->user_id;
        });

        $gate->define('delete-place', function ($user, $place) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $place->user_id;
        });


        // Story page

        $gate->define('edit-story', function ($user, $story) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $story->user_id;
        });

        $gate->define('transfer-story', function ($user, $story) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $story->user_id;
        });

        $gate->define('delete-story', function ($user, $story) {
            return $user->role === 'admin' || $user->role === 'editor' || $user->id === $story->user_id;
        });


        // Image

        $gate->define('delete-image', function ($user, $image) {
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

        $gate->define('create-city', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        $gate->define('edit-city', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        $gate->define('delete-city', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });


        // Country page

        $gate->define('create-country', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        $gate->define('edit-country', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        $gate->define('delete-country', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });


        // Tag page

        $gate->define('create-tag', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        $gate->define('edit-tag', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        $gate->define('delete-tag', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });
    }
}
