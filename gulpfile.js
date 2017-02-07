const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

var paths = {
    jquery: 'vendor/jquery/',
    bootstrap: 'vendor/bootstrap/',
    bowerComponents: 'bower_components/'
};

elixir(function (mix) {
    mix.styles([
        paths.bowerComponents + 'bootstrap/dist/css/bootstrap.css',
        paths.bowerComponents + 'jquery-prettyPhoto/css/prettyPhoto.css',
        'css/' + paths.bootstrap + 'hoverex-all.css',
        'css/' + paths.bootstrap + 'bootstrap-solid-theme.css',
        paths.bowerComponents + 'font-awesome/css/font-awesome.min.css',
        paths.bowerComponents + 'c3/c3.css',
        'css/custom.css'
    ], null, 'resources/assets/');

    mix.scripts([
        paths.bowerComponents + 'jquery/dist/jquery.js',
        paths.bowerComponents + 'bootstrap/dist/js/bootstrap.js',
        paths.bowerComponents + 'retina.js/dist/retina.js',
        'js/' + paths.jquery + 'jquery.hoverdir.js',
        'js/' + paths.jquery + 'jquery.hoverex.min.js',
        paths.bowerComponents + 'jquery-prettyPhoto/js/jquery.prettyPhoto.js',
        'js/' + paths.jquery + 'jquery.isotope.min.js',
        paths.bowerComponents + 'd3/d3.js',
        paths.bowerComponents + 'c3/c3.js',
        'js/app.js'
    ], null, 'resources/assets/');

    mix.version(['public/css/all.css', 'public/js/all.js']);
    mix.copy('resources/assets/' + paths.bowerComponents + 'bootstrap/dist/fonts', 'public/build/fonts');
    mix.copy('resources/assets/' + paths.bowerComponents + 'font-awesome/fonts', 'public/build/fonts');
});
