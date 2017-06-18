const { mix } = require('laravel-mix');
let paths = {
    'gentelella': './node_modules/gentelella/',
    'gentelella_vendors': './node_modules/gentelella/vendors/',
    'resources': 'resources/assets/',
}

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

mix.combine([
        paths.gentelella_vendors + 'bootstrap/dist/css/bootstrap.min.css', // Bootstrap
        paths.gentelella_vendors + 'font-awesome/css/font-awesome.min.css', // Font awesome
        paths.gentelella_vendors + 'bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css', // Bootstrap Progress Bar
        paths.gentelella + 'build/css/custom.min.css', // Gentelella
        paths.resources + 'sass/custom.css'
    ],  'public/css/all.css')
    .version();

mix.combine([
        paths.gentelella_vendors + 'jquery/dist/jquery.min.js', // jQuery
        paths.gentelella_vendors + 'bootstrap/dist/js/bootstrap.min.js', // Bootstrap
        paths.resources + 'js/custom.js', // Gentelella
    ], 'public/js/all.js')
    .version();

mix.copy([
    paths.gentelella_vendors + 'bootstrap/fonts/', // Bootstrap
    paths.gentelella_vendors + 'font-awesome/fonts/', // Font Awesome
], 'public/fonts');

mix.copy([
    paths.gentelella_vendors + 'bootstrap/fonts/', // Bootstrap
    paths.gentelella_vendors + 'font-awesome/fonts/', // Font Awesome
], 'public/build/fonts');
