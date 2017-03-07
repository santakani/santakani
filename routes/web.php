<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('auth/facebook', 'Auth\OAuthController@redirectToFacebook');
    Route::get('auth/facebook/callback', 'Auth\OAuthController@handleFacebookCallback');
    Route::get('auth/google', 'Auth\OAuthController@redirectToGoogle');
    Route::get('auth/google/callback', 'Auth\OAuthController@handleGoogleCallback');
    Route::get('auth/twitter', 'Auth\OAuthController@redirectToTwitter');
    Route::get('auth/twitter/callback', 'Auth\OAuthController@handleTwitterCallback');

    Route::get('/', 'HomeController@index');
    Route::get('search', 'SearchController@index');

    Route::get('about', 'PageController@about');
    Route::get('privacy', 'PageController@privacy');
    Route::get('terms', 'PageController@terms');

    Route::get('sitemap', 'SitemapController@index');

    Route::get('trash', 'TrashController@index');
    Route::get('trash/designer', 'TrashController@designer');
    Route::get('trash/design', 'TrashController@design');
    Route::get('trash/place', 'TrashController@place');
    Route::get('trash/story', 'TrashController@story');

    Route::resource('user', 'UserController', ['except' => [
        'create', 'store'
    ]]);

    Route::resource('image', 'ImageController', ['except' => [
        'create', 'edit', 'update'
    ]]);

    Route::resource('option', 'OptionController', ['except' => [
        'create', 'edit',
    ]]);

    Route::resource('address', 'AddressController', ['except' => [
        'create', 'edit',
    ]]);

    Route::resource('like', 'LikeController', ['only' => ['store', 'destroy']]);

    Route::resource('tag', 'TagController');

    Route::resource('country', 'CountryController');

    Route::resource('city', 'CityController');

    Route::resource('designer', 'DesignerController');
    Route::resource('design', 'DesignController');

    Route::resource('place', 'PlaceController');

    Route::resource('story', 'StoryController');

    // User settings
    Route::group(['middleware' => ['auth'], 'namespace' => 'Settings', 'prefix' => 'settings'], function() {
        Route::get('/', function () {
            return redirect('settings/profile');
        });

        Route::get('profile', 'ProfileController@edit');
        Route::post('profile', 'ProfileController@update');

        Route::get('account', 'AccountController@edit');
        Route::post('account', 'AccountController@update');

        Route::get('password', 'PasswordController@edit');
        Route::post('password', 'PasswordController@update');

        Route::get('address', 'AddressController@index');

        Route::get('pages', 'PageController@index');

        Route::get('story', 'StoryController@index');

        Route::match(['post', 'put', 'patch'], 'setting', 'SettingController@update');
    });

    // Admin panel
    Route::group(['middleware' => ['auth', 'admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
        Route::get('/', 'AdminController@index');
        Route::get('log/activity', 'ActivityLogController@index');
        Route::get('user', 'AdminController@user');
        Route::get('image', 'AdminController@image');
    });

    Route::get('help', 'HelpController@index');
});

