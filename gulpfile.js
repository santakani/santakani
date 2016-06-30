var elixir = require('laravel-elixir');

require('laravel-elixir-requirejs');

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
    mix.sass('editor.scss', 'public/css');
    mix.browserify('app.js');

    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap');
    mix.copy('node_modules/font-awesome/fonts', 'public/fonts/font-awesome');
    mix.copy('node_modules/lightgallery/dist/fonts', 'public/fonts/lightgallery');
    mix.copy('node_modules/lightgallery/dist/img', 'public/img/lightgallery');
    mix.copy('node_modules/flag-icon-css/flags', 'public/img/flags');
    mix.copy('node_modules/roboto-fontface/fonts', 'public/fonts/roboto');
    mix.copy('node_modules/tinymce', 'public/lib/tinymce');

    mix.copy('resources/assets/img', 'public/img');
});
