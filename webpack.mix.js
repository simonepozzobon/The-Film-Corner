const { mix } = require('laravel-mix')


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
  .js('resources/assets/admin/js/keywords.js', 'public/js/admin/')
  .js('resources/assets/admin/js/footer/footer.js', 'public/js/admin/')
  .js('resources/assets/admin/js/captions/captions.js', 'public/js/admin/')
  .js('resources/assets/admin/js/teachers/teachers.js', 'public/js/admin/')
  .js('resources/assets/admin/js/guests/guests.js', 'public/js/admin/')
  .js('resources/assets/admin/js/contest.js', 'public/js/admin/')


  .js('resources/assets/js/home-mojs.js', 'public/js/city.js')
  .js('resources/assets/js/app/intercut-crosscutting.js', 'public/js/app/intercut-crosscutting.js')
  .js('resources/assets/js/app/sound-studio.js', 'public/js/app/sound-studio.js')
  .js('resources/assets/js/timeline/timeline.js', 'public/js')
  .js('resources/assets/js/timeline-audio/timelineaudio.js', 'public/js')
  .js('resources/assets/js/soundscapes/soundscapes.js', 'public/js')
  .js('resources/assets/js/app-loading/loader.js', 'public/js/loader.js')

  .js('resources/assets/js/socket-test', 'public/js')
  .js('resources/assets/js/teacher-chat', 'public/js')
  .js('resources/assets/js/network', 'public/js')
  .js('resources/assets/js/network-single', 'public/js')
  .js('resources/assets/js/teacher-profile/teacher-profile', 'public/js')
  .js('resources/assets/js/notification/notifications', 'public/js')
  .js('resources/assets/js/feedback-toolbar/feedback-toolbar', 'public/js')
  .js('resources/assets/js/upload/upload', 'public/js')
  .js('resources/assets/js/fullscreen/message.js', 'public/js')


  .js('resources/assets/js/conference/speakers', 'public/js/conference')

  .js('resources/assets/js/studio-home.js', 'public/js/app')
  .js('resources/assets/js/first-visit', 'public/js')
  // .js('resources/assets/js/scroll', 'public/js')

  .js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app/2.1/angular-media-timeline.scss', 'public/css/app/2.1/timeline-main.css')
  .less('resources/assets/sass/app/2.1/timeline.less', 'public/css/app/2.1/timeline.css')
  .sass('resources/assets/sass/app/2.1/dropzone.scss', 'public/css/app/2.1/dropzone.css')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .sass('resources/assets/admin/sass/app.scss', 'public/css/admin/admin.css')
  .extract(['jquery', 'tether', 'bootstrap', 'any-resize-event'])
  .autoload({
    jquery: ['$', 'jQuery', 'jquery'],
    tether: ['Tether'],
  })
  .browserSync({
    proxy: 'http://thefilmcorner.test:89/',
    browser: 'google chrome',
    port: 3006,
  })
  .webpackConfig({
    resolve:{
      alias: {
        'styles': path.resolve(__dirname, 'resources/assets/sass'),
        '_js': path.resolve(__dirname, 'resources/assets/js')
      }
    }
  })
