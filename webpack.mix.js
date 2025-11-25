// OS + Platform:
// ...

// Core:
const mix = require('laravel-mix');

// Plugins:
// ...

mix
    .setPublicPath('./web/assets/dist')
    .sass('src/css/site.scss', './web/assets/dist/css')
    .js('src/js/site.js', './web/assets/dist/js')
    .copy('src/images', './web/assets/dist/images')
    .copy('src/fonts', './web/assets/dist/fonts')
    .copy('src/favicon.ico', './web/assets/dist')

    .options({
        autoprefixer: false,
        processCssUrls: false,
        postCss: [
            require('cssnano')(),
        ],
    })

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps(true, 'source-map');
}
