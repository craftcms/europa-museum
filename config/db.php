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
    'server' => App::env('CRAFT_DB_SERVER'),
    'user' => App::env('CRAFT_DB_USER'),
    'password' => App::env('CRAFT_DB_PASSWORD'),
    'database' => App::env('CRAFT_DB_DATABASE'),
    'schema' => App::env('CRAFT_DB_SCHEMA') ?: 'public',
    'tablePrefix' => App::env('CRAFT_DB_TABLE_PREFIX'),
    'port' => App::env('CRAFT_DB_PORT') ?: 5432,
];
