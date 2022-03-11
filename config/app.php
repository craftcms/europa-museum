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
use \pixelandtonic\dynamodb\drivers\DynamoDbSession;
use \pixelandtonic\dynamodb\drivers\DynamoDbCache;
use yii\web\DbSession;

$components = [
    'mailer' => null,
];

if ($table = App::env('DYNAMODB_TABLE_CACHE')) {
    $components['cache'] = [
        'class' => DynamoDbCache::class,
        'table' => $table,
        'region' => App::env('AWS_REGION'),
    ];
}

if ($table = App::env('DYNAMODB_TABLE_SESSION')) {
    $components['session'] = static function() {
        return Craft::createObject(
            ['class' => DbSession::class] + App::sessionConfig(),
        );
    };
}

return [
    '*' => [
        'id' => App::env('CRAFT_CLOUD_ID') ?: 'CraftCMS',
        'modules'   => [
            'demos' => \modules\demos\Module::class,
        ],
        'bootstrap' => ['demos'],
        'components' => [
            'mailer' => null,
        ] + $components,
    ],
    'dev' => [
        'components' => $components,
    ]
];
