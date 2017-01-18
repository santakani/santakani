var elixir = require('laravel-elixir');
require('laravel-elixir-svgstore');

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
    // Generate SVG sprites
    // https://css-tricks.com/svg-sprites-use-better-icon-fonts/
    mix.svgstore();

    // Compile SaSS and JavaScript
    mix.sass('app.scss', 'public/css');
    mix.browserify('app.js');

    // Versioned CSS and JavaScript output
    mix.version(['css/app.css', 'js/app.js']);

    // Copy files to public folder
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap');
    mix.copy('node_modules/font-awesome/fonts', 'public/fonts/font-awesome');
    mix.copy('node_modules/lightgallery/dist/fonts', 'public/fonts/lightgallery');
    mix.copy('node_modules/lightgallery/dist/img', 'public/img/lightgallery');
    mix.copy('node_modules/lightslider/dist/img', 'public/img/lightslider');
    mix.copy('node_modules/flag-icon-css/flags', 'public/img/flags');
    mix.copy('node_modules/roboto-fontface/fonts', 'public/fonts/roboto');
    mix.copy('node_modules/leaflet/dist/images', 'public/img/leaflet');
    mix.copy('node_modules/tinymce', 'public/lib/tinymce');
    mix.copy('resources/assets/js/tinymce', 'public/lib/tinymce');
    mix.copy('resources/assets/img', 'public/img');
});
