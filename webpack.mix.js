const { mix } = require('laravel-mix');


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
    .js([
      'resources/assets/admin/js/plugins/image-picker.js',
      'resources/assets/admin/js/custom.js'
    ], 'public/js/admin/admin.js').minify('public/js/admin/admin.js')
    .js('resources/assets/admin/js/video.js', 'public/js/admin/video.js')
    .js('resources/assets/admin/js/audio.js', 'public/js/admin/audio.js')
    .js('resources/assets/admin/js/image.js', 'public/js/admin/image.js')
    .js('resources/assets/admin/js/main.js', 'public/js/admin/main.js')
    .js('resources/assets/admin/js/translate.js', 'public/js/admin/')
    .js('resources/assets/js/home-mojs.js', 'public/js/city.js')
    .js('resources/assets/js/app/intercut-crosscutting.js', 'public/js/app/intercut-crosscutting.js')
    .js('resources/assets/js/app/sound-studio.js', 'public/js/app/sound-studio.js')

    .js('resources/assets/js/socket-test', 'public/js')
    .js('resources/assets/js/teacher-chat.js', 'public/js')
    .js('resources/assets/js/network.js', 'public/js')
    .js('resources/assets/js/network-single.js', 'public/js')

    .js('resources/assets/js/conference/speakers.js', 'public/js/conference')

    .js('resources/assets/js/studio-home.js', 'public/js/app')

    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app/2.1/angular-media-timeline.scss', 'public/css/app/2.1/timeline-main.css')
    .less('resources/assets/sass/app/2.1/timeline.less', 'public/css/app/2.1/timeline.css')
    .sass('resources/assets/sass/app/2.1/dropzone.scss', 'public/css/app/2.1/dropzone.css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/admin/sass/app.scss', 'public/css/admin/admin.css')
    .extract(['jquery', 'tether', 'bootstrap'])
    .autoload({
        jquery: ['$', 'jQuery', 'jquery'],
        tether: ['Tether'],
    })
    .browserSync({
      proxy: 'http://www.simonepozzobon.dev:80/',
      browser: 'google chrome'
    });
