const mix = require('laravel-mix');
mix.setResourceRoot('./');
mix.js('client/main.js', 'dist/main.js');

mix.webpackConfig({
    devtool: "source-map"
});
