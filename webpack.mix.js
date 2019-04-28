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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/pdfobject.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/invoices.scss', 'public/css')
    .sass('resources/sass/nda.scss', 'public/css')
    .sass('resources/sass/personal_details.scss', 'public/css')
    .sass('resources/sass/login.scss', 'public/css')
    .extract();

if (mix.inProduction()) {
    mix.version();
}