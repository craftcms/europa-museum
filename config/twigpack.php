<?php

use craft\helpers\App;

return [
    'useAbsoluteUrl' => true,
    'errorEntry' => '',
    'cacheKeySuffix' => '',
    'manifest' => [
        'legacy' => 'mix-manifest.json',
        'modern' => 'mix-manifest.json',
    ],
    'server' => [
        'manifestPath' => \craft\cloud\Helper::artifactUrl('assets/dist/'),
        'publicPath' => \craft\cloud\Helper::artifactUrl('assets/dist/'),
    ],
    'useDevServer' => (bool) App::env('TWIGPACK_MANIFEST_PATH'),
    'devServer' => [
        'manifestPath' => App::env('TWIGPACK_MANIFEST_PATH'),
        'publicPath' => App::env('TWIGPACK_PUBLIC_PATH'),
    ],
    'devServerBuildType' => 'modern',
    'cspNonce' => '',
    'localFiles' => [
        'basePath' => '@webroot/',
    ],
];
