const mix = require('laravel-mix');
mix.setResourceRoot('../');
mix.js('client/javascript/main.js', 'dist/js/main.js');
mix.js('client/javascript/charts.js', 'dist/js/charts.js');
mix.sass('client/scss/main.scss', 'dist/css/main.css');
mix.sass('client/scss/calendar.scss', 'dist/css/calendar.css');

mix.webpackConfig({
    devtool: "source-map"
});
