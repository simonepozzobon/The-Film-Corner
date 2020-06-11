let mix = require("laravel-mix");
require("laravel-mix-polyfill");

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

mix.js("resources/assets/js/app.js", "public/js")
    .sass("resources/assets/sass/app.scss", "public/css")
    .autoload({
        jquery: ["$", "jQuery", "jquery"],
        tether: ["Tether"]
    })
    .webpackConfig({
        resolve: {
            alias: {
                styles: path.resolve(__dirname, "resources/assets/sass"),
                _js: path.resolve(__dirname, "resources/assets/js")
            }
        }
    })
    .polyfill({
        enabled: false,
        useBuiltIns: "usage",
        targets: "last 2 version, not dead",
        debug: true
    })
    .browserSync({
        proxy: "http://tfc.test",
        port: 3020,
        browser: "google chrome",
        files: [
            "public/js/**/*.js",
            "public/css/**/*.css",
            "resources/views/**/*.php"
        ]
    });
