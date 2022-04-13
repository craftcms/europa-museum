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
use pixelandtonic\dynamodb\DynamoDbCache;
use pixelandtonic\dynamodb\DynamoDbConnection;
use pixelandtonic\dynamodb\DynamoDbSession;
use samdark\log\PsrTarget;

$appId = App::env('CRAFT_APP_ID');
$prefix = substr(md5($appId), 0, 5);

$dynamoDb = [
    'class' => DynamoDbConnection::class,
    'endpoint' => App::env('DYNAMODB_ENDPOINT'),
    'formatKey' => static fn($key) => "$prefix#$key",
];

$session = static fn() => Craft::createObject([
    'class' => DynamoDbSession::class,
    'dynamoDb' => [
        'tableName' => App::env('DYNAMODB_TABLE_SESSION'),
    ] + $dynamoDb,
] + App::sessionConfig());

$cache = static fn() => Craft::createObject([
    'class' => DynamoDbCache::class,
    'defaultDuration' => Craft::$app->getConfig()->getGeneral()->cacheDuration,
    'dynamoDb' => [
        'tableName' => App::env('DYNAMODB_TABLE_CACHE'),
    ] + $dynamoDb
]);

return [
    'id' => $appId,
    'modules'   => [
        'demos' => Module::class,
    ],
    'bootstrap' => ['demos'],
    'components' => [
        'log' => [
            'monologTargetConfig' => [
                'level' => \Psr\Log\LogLevel::WARNING,
            ],
            'targets' => App::env('BUGSNAG_API_KEY') ? [
                [
                    'class' => PsrTarget::class,
                    'logger' => (new Monolog\Logger('bugsnag'))
                        ->pushHandler(new BugsnagHandler(Client::make(App::env('BUGSNAG_API_KEY')))),
                ]
            ] : [],
        ],
        'dynamoDb' => $dynamoDb,
        'session' => $session,
        'cache' => $cache,
    ],
];
