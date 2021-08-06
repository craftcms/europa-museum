// copy.settings.js

// node modules
require('dotenv').config();
const path = require('path');

// settings
module.exports = {
    copy: [
        {
            from: '**/*',
            context: '../src/fonts/',
            to: 'fonts/',
            noErrorOnMissing: true,
        }
    ],
};
