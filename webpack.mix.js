const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts([
    'resources/plantilla/js/popper.min.js',
    'resources/plantilla/js/Chart.min.js',
    'resources/plantilla/js/pace.min.js',
    'resources/plantilla/js/template.js',
    'resources/plantilla/js/sweetalert2.all.js'
], 'public/js/plantilla.js')
.js(['resources/js/app.js'],'public/js/app.js');