const { mix } = require('laravel-mix');

const _npm = 'node_modules/';
const _r = 'resources/assets/admin/';
const _o = 'resources/assets/admin/dist/';
const _d = 'public/';

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
    .js('resources/assets/js/home-mojs.js', 'public/js/city.js')
    .js('resources/assets/js/app/intercut-crosscutting.js', 'public/js/app/intercut-crosscutting.js')
    .js('resources/assets/js/app/sound-studio.js', 'public/js/app/sound-studio.js')
    .sass('resources/assets/sass/app/2.1/angular-media-timeline.scss', 'public/css/app/2.1/timeline-main.css')
    .less('resources/assets/sass/app/2.1/timeline.less', 'public/css/app/2.1/timeline.css')
    .sass('resources/assets/sass/app/2.1/dropzone.scss', 'public/css/app/2.1/dropzone.css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .js([
      _r+'js/plugins/image-picker.js',
      _r+'js/custom.js'
    ], _d+'js/admin/admin.js')
    .minify(_d+'js/admin/admin.js')
    .js(_r+'js/test.js', _d+'js/admin/test.js')
    .sass(_r+'sass/app.scss', _d+'css/admin/admin.css')
    .extract(['jquery', 'tether', 'bootstrap'])
    .autoload({
        jquery: ['$', 'jQuery', 'jquery'],
        tether: ['Tether'],
    })
    .browserSync({
      proxy: 'http://www.simonepozzobon.dev:8888/'
    });
