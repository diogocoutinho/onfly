const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    
    .webpackConfig(require('./webpack.config'))
    .sourceMaps()
    .browserSync({
        open: false,
        proxy: {
            target: "onfly:8003", // replace with your web server container
            proxyReq: [
                function(proxyReq) {
                    proxyReq.setHeader('HOST', 'onfly:8003'); // replace with your site host
                }
            ]
        }
    });

if (mix.inProduction()) {
    mix.version();
}
