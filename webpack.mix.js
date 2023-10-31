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
mix.override((config) => {
    delete config.watchOptions;
});
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/committeeCard.scss','public/css/committeeCard.css')
    .sass('resources/sass/custom.scss', 'public/css/custom.css')
    .sass('resources/sass/tabs.scss', 'public/css/tabs.css')
    .sass('resources/sass/checkbox.scss', 'public/css/checkbox.css')
    .sass('resources/sass/adminCards.scss', 'public/css/adminCards.css')
    .sass('resources/sass/party.scss', 'public/css/party.css')
    .js('resources/js/scrollonload.js', 'public/js')
    .js('resources/js/party.js', 'public/js')
    .js('resources/js/GroupSelectTickets.js','public/js')
    .vue()
    .version();
