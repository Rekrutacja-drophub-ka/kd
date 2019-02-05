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

mix.js('resources/js/product/index.js', 'public/js/product')
    .sass('resources/sass/product/index.scss', 'public/css/product')
    .sass('resources/sass/file/statistics.scss', 'public/css/file');
