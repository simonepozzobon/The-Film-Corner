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
    // Install (copy css to resources folder)
    // .copy('node_modules/videogular-themes-default/videogular.css', 'resources/assets/sass/app/2.1/videogular.scss')
    // .copy('node_modules/angular-media-timeline/main.css', 'resources/assets/sass/app/2.1/angular-media-timeline.scss')
    // .copy('node_modules/angular-media-timeline/timeline.less', 'resources/assets/sass/app/2.1/timeline.less')

    // Main App js
    .js('resources/assets/js/app.js', 'public/js')

    // Home Animation
    .js('resources/assets/js/home-mojs.js', 'public/js/city.js')

    // App 2.1
    // intercut/cross-cutting: take 2 sequences from different
    // libraries and edit them as an intercut.
    .js('resources/assets/js/app/2.1/script.js', 'public/js/app/2.1/script.js')
    // .sass('resources/assets/sass/app/2.1/videogular.scss', 'public/css/app/2.1/style.css')
    // .sass('node_modules/video.js/src/css/vjs-cdn.scss', 'public/css/app/2.1/video-js.css')
    .sass('resources/assets/sass/app/2.1/angular-media-timeline.scss', 'public/css/app/2.1/timeline-main.css')
    .less('resources/assets/sass/app/2.1/timeline.less', 'public/css/app/2.1/timeline.css')
    .sass('resources/assets/sass/app/2.1/dropzone.scss', 'public/css/app/2.1/dropzone.css')
    // .sass('node_modules/dropzone/src/dropzone.scss', 'public/css/app/2.1/dropzone.css')

    // ADMIN SCRIPTS

    // CSS
    .sass('resources/assets/sass/app.scss', 'public/css')

    .webpackConfig({
        target: 'node'
    });
