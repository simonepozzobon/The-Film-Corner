const { mix } = require('laravel-mix');

const _npm = 'node_modules/';
const _r = 'resources/assets/admin/';
const _o = 'resources/assets/admin/dist/';
const _d = 'public/';

mix
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
  // proxy: {
  //           target: '127.0.0.1',
  //           reqHeaders: function () {
  //               return { host: 'http://www.simonepozzobon.dev:8888/' };
  //           }
  //       }
});
