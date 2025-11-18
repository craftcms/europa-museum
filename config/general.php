<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here.
 * You can see a list of the default settings in src/config/GeneralConfig.php
 */

use craft\config\GeneralConfig;
use craft\helpers\App;

// Removed --column-inserts to reduce size and prevent OOM errors
$backupCommand = 'PGPASSWORD="{password}" pg_dump' .
' --dbname={database}' .
' --host={server}' .
' --port={port}' .
' --username={user}' .
' --if-exists' .
' --clean' .
' --no-owner' .
' --no-privileges' .
' --no-acl' .
' --file="{file}"' .
' --schema={schema}';

return GeneralConfig::create()
    ->omitScriptNameInUrls(true)
    ->allowUpdates(false)
    ->backupCommand($backupCommand)
    ->defaultSearchTermOptions([
        'subLeft' => true,
        'subRight' => true,
    ])
    ->disallowRobots(true)
    ->useEmailAsUsername(true)
    ->aliases([
        '@uploads' => (App::env('S3_BASE_URL') ?: App::env('PRIMARY_SITE_URL')) . '/uploads',
        '@dist' => (App::env('S3_BASE_URL') ?: App::env('PRIMARY_SITE_URL')) . '/assets/dist',
    ])
;
