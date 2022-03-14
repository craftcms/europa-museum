<?php
/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app/main.php and [web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 */

use craft\helpers\App;
use yii\web\DbSession;
use modules\demos\Module;

$components = [
    'mailer' => null,
    'session' => static function() use ($table) {
        return Craft::createObject([
            'class' => DbSession::class,
        ] + App::sessionConfig());
    }
];

return [
    '*' => [
        'id' => App::env('CRAFT_CLOUD_ID') ?: 'CraftCMS',
        'modules'   => [
            'demos' => Module::class,
        ],
        'bootstrap' => ['demos'],
        'components' => $components,
    ],
    'dev' => [

    ],
];
