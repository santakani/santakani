var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'public/css');
    mix.sass('bootstrap.scss', 'public/css');
    mix.scriptsIn('resources/assets/js', 'public/js/app.js');
    mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.js', 'public/js/bootstrap.js');
});
