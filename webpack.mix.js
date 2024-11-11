const mix = require('laravel-mix');
const webpack = require('webpack'); // Add this line

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .sourceMaps();

// Add the following lines to expose .env variables to JavaScript
mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                MIX_PUSHER_APP_KEY: JSON.stringify(process.env.PUSHER_APP_KEY),
                MIX_PUSHER_APP_CLUSTER: JSON.stringify(process.env.PUSHER_APP_CLUSTER)
            }
        })
    ]
});
