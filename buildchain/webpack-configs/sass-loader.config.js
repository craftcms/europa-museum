// postcss-loader.config.js
// returns a webpack config object to handle .pcss & .css loading

// node modules
const path = require('path');

// webpack plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

// return a webpack config
// eslint-disable-next-line @typescript-eslint/no-unused-vars
module.exports = (type = 'modern', settings) => {
// common config
    const common = (loaders) => ({
        module: {
            rules: [
                {
                    test: /\.(scss|sass|css)$/,
                    use: [
                        ...loaders,
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: false,
                                url: false,
                                import: false,
                            },
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: false,
                            }
                        }
                    ]
                },
            ],
        },
    });
    // configs
    const configs = {
        // development configs
        development: {
            // legacy development config
            legacy: {
            },
            // modern development config
            modern: {
                ...common(
                    [{
                    loader: 'style-loader',
                    }]
                ),
            },
        },
        // production configs
        production: {
            // legacy production config
            legacy: {
                ...common(
                    [
                        MiniCssExtractPlugin.loader
                    ],
                ),
            },
            // modern production config
            modern: {
                module: {
                    rules: [{
                        test: /\.(scss|sass|css)$/,
                        loader: 'ignore-loader'
                    }],
                },
            },
        }
    };

    return configs[process.env.NODE_ENV][type];
}
