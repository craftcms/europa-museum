// app.settings.js

// node modules
require('dotenv').config();
const path = require('path');

// settings
module.exports = {
    alias: {
        '@': path.resolve('../src'),
    },
    copyright: 'Europa Museum.',
    entry: {
        'app': [
            '@/js/app.ts',
            '@/js/site.js',
            '@/css/site.scss',
        ],
    },
    extensions: ['.ts', '.js', '.vue', '.json'],
    name: 'Example Project',
    paths: {
        dist: path.resolve('../cms/web/dist/'),
    },
    urls: {
        criticalCss: 'http://nginx/',
        publicPath: () => process.env.PUBLIC_PATH || '/dist/',
    },
};
