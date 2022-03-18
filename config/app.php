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

use Bugsnag\Client;
use craft\helpers\App;
use MeadSteve\MonoSnag\BugsnagHandler;
use modules\demos\Module;
use samdark\log\PsrTarget;

return [
    'modules'   => [
        'demos' => Module::class,
    ],
    'bootstrap' => ['demos'],
    'components' => [
        'log' => [
            'targets' => App::env('BUGSNAG_API_KEY') ? [
                [
                    'class' => PsrTarget::class,
                    'logger' => (new Monolog\Logger('bugsnag'))
                        ->pushHandler(new BugsnagHandler(Client::make(App::env('BUGSNAG_API_KEY')))),
                ]
            ] : [],
        ],
    ]
];
