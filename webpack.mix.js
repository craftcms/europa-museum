const mix = require('laravel-mix');

/* Mix Plugins */
// require('laravel-mix-bundle-analyzer');
// require('laravel-mix-criticalcss');
require('laravel-mix-purgecss');

mix.cdnify = function(path, cdn) {
    let file = new File(path);

    // Replace all occurrences of /img/ with CDN URL prepended
    let contents = file.read().replace(/\/assets\/dist\//g, cdn+"/assets/dist/");
    file.write(contents);

    // Update version hash in manifest
    Mix.manifest.hash(file.pathFromPublic()).refresh();

    return this;
}.bind(mix)

mix
    .setPublicPath('./web/assets/dist')
    .sass('src/css/site.scss', './web/assets/dist/css')
    .js('src/js/site.js', './web/assets/dist/js')
    .copy('src/images', './web/assets/dist/images')
    .copy('src/fonts', './web/assets/dist/fonts')
    // .copy('src/favicon.ico', './web/dist')

    .options({
        autoprefixer: false,
        processCssUrls: false,
        postCss: [
            require('cssnano')(),
        ],
    })

    .purgeCss({
        enabled: mix.inProduction(),
        globs: [
            path.join(__dirname, '/templates/**/*.{html,twig}'),
            path.join(__dirname, '/src/css/**/*.{scss,css}'),
        ],
        defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
        extensions: ['html', 'js', 'php', 'twig', 'scss', 'css'],
        whitelist: ['first-load', 'loading', 'is-ie', 'is-device', 'is-phone', 'is-desktop', 'lazypicture', 'lazyloading', 'lazyloaded', 'lazyfade', 'lazyblur', 'animated-gif', 'has-scroll-smooth', 'has-scroll-init', 'has-scroll-scrolling', 'has-scroll-dragging', 'c-scrollbar', 'c-scrollbar_thumb', 'is-inview', 'flickity-button', 'flickity-button-icon', 'previous', 'next', 'arrow', 'flickity-page-dots', 'is-selected', 'scrolled', 'page-404', 'page-503', 'page-error', '[data-router-wrapper]', '[data-page="home"]', '[data-page="exhibitions"]', '[data-page="visit"]', '[data-page="news"]', '[data-page="about"]', '[data-page="contact"]', '[data-router-view="exhibitions"]', '[data-router-view="visit"]', '[data-router-view="news"]', '[data-router-view="newsArticle"]', '[data-router-view="about"]', '[data-router-view="contact"]', '[data-router-view="styleguide"]', 'active', 'word', 'whiteText', 'exhibit-odd', 'exhibit-even', 'exhibit-1', 'exhibit-2', 'exhibit-3', 'exhibit-4', 'dark-ui', 'has-icon', 'no-blocks', 'isFirst', 'is-image', 'is-entry', 'is-highlighted', 'topBorder', 'layout-imageLeft', 'layout-imageFullWidth', 'layout-imageRight', 'narrowWidth', 'no-hero-image', 'figure']
    })

    // .criticalCss({
    //     enabled: mix.inProduction(),
    //     paths: {
    //         base: 'https://europamuseum.co/,
    //         templates: './templates/_/',
    //         suffix: '-critical.min'
    //     },
    //     urls: [
    //         {
    //             url: '/',
    //             template: 'home'
    //         },
    //     ],
    //     options: {
    //         minify: true,
    //         width: 1440,
    //         height: 1200,
    //     },
    // })

    .babelConfig({
        plugins: [
            '@babel/plugin-proposal-class-properties',
            '@babel/plugin-proposal-function-bind',
            '@babel/plugin-syntax-dynamic-import',
            '@babel/plugin-transform-runtime',
        ],
    });

// .extract();

if (mix.inProduction()) {
    mix.version();

    mix.then(function() {
        const cdnUrl = `${process.env.CRAFT_CLOUD_ARTIFACT_BASE_URL || ''}`
        mix.cdnify('./web/assets/dist/css/site.css', cdnUrl)
        mix.cdnify('./web/assets/dist/js/site.js', cdnUrl)
    })
} else if (process.env.MIX_ENV == 'sync') {
    mix
        .sourceMaps(true, 'source-map')
        .browserSync({
            proxy: new URL(process.env.PRIMARY_SITE_URL).hostname,
            port: 3000,
            files: [
                './web/assets/dist/css/{*,**/*}.css',
                './web/assets/dist/js/{*,**/*}.js',
                './templates/{*,**/*}.{html,twig}',
            ],
        });
} else {
    mix
        .sourceMaps(true, 'source-map');
}
