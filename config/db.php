<?php
/**
 * Database Configuration
 *
 * All of your system's database connection settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/DbConfig.php.
 */

use craft\db\Connection;
use craft\helpers\App;

return [
    'driver' => Connection::DRIVER_PGSQL,
    'server' => App::env('DB_SERVER'),
    'user' => App::env('DB_USER'),
    'password' => App::env('DB_PASSWORD'),
    'database' => App::env('DB_DATABASE'),
    'schema' => App::env('DB_SCHEMA') ?: 'public',
    'tablePrefix' => App::env('DB_TABLE_PREFIX'),
    'port' => App::env('DB_PORT') ?: 5432,
];
