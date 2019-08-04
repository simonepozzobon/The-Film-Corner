let mix = require('laravel-mix')
// require('laravel-mix-polyfill')

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
    .setPublicPath(path.normalize('public/backend'))
    .options({
        processCssUrls: false
    })
    .js('resources/assets/js/admin/admin.js', 'js/admin.js')
    .sass('resources/assets/sass/admin-app.scss', 'css/admin.css')
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
    // .polyfill({
    //     enabled: true,
    //     useBuiltIns: 'usage',
    //     targets: 'last 2 version, not dead',
    //     debug: true
    // })
    .browserSync({
        proxy: 'http://tfc.test',
        startPath: '/admin',
        port: 3001,
        browser: 'google chrome',
        files: [
            'app/{*,**/*}.*',
            'resources/{*,**/*}.*',
            'public/{*,**/*}.*',
        ]
    })
