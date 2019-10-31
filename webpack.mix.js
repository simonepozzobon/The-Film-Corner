const mix = require('laravel-mix');
const section = process.env.SECTION

if (section) {
    require( path.resolve(__dirname) + `/webpack.${section}.mix.js` )
}
