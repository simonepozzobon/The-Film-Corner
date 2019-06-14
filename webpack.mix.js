let mix = require('laravel-mix')
require('laravel-mix-polyfill')

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
//

mix
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/admin/sass/app.scss', 'public/css/admin/admin.css')
    .autoload({
        jquery: ['$', 'jQuery', 'jquery'],
        tether: ['Tether'],
    })
    .webpackConfig({
        resolve:{
            alias: {
                'styles': path.resolve(__dirname, 'resources/assets/sass'),
                '_js': path.resolve(__dirname, 'resources/assets/js')
            }
        }
    })
    .polyfill({
        enabled: true,
        useBuiltIns: 'usage',
        targets: 'last 2 version, not dead',
        debug: true
    })
    .browserSync({
        proxy: 'http://thefilmcorner.test',
        port: 3019,
        browser: 'google chrome',
    })
