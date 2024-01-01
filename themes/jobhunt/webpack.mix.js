const mix = require('laravel-mix');
mix.setResourceRoot('../');
mix.js('client/javascript/main.js', 'dist/js/main.js');
mix.sass('client/scss/main.scss', 'dist/css/main.css');

mix.webpackConfig({
    devtool: "source-map"
});
