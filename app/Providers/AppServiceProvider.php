<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Map string in *_type to model classes
        Relation::morphMap([
            'designer' => \App\Designer::class,
            'place' => \App\Place::class,
            'story' => \App\Story::class,
            'country' => \App\Country::class,
            'city' => \App\City::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
