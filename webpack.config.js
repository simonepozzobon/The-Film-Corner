var webpack = require('webpack');
var path = require('path');
var fs = require('fs');

var nodeModules = {};
fs.readdirSync('node_modules')
  .filter(function(x) {
    return ['.bin'].indexOf(x) === -1;
  })
  .forEach(function(mod) {
    nodeModules[mod] = 'commonjs ' + mod;
  });

module.exports = {
  entry: './resources/assets/js/app/2.1/script.js',
  target: 'node',
  output: {
    path: path.join(__dirname, 'public/js/app/2.1/'),
    filename: 'script.js'
  },
  externals: {
    "fluent-ffmpeg" : {
      commonjs2: "fluent-ffmpeg"
    }
  },
  plugins: [

  ],
  devtool: 'sourcemap'
}
