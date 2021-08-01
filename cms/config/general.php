<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here.
 * You can see a list of the default settings in src/config/GeneralConfig.php
 */

use craft\helpers\App;

return [
    '*' => [
        'aliases' => [
            '@web' => App::env('DEFAULT_SITE_URL'),
            '@webroot' => App::env('WEB_ROOT_PATH'),
        ],
        'allowUpdates' => (bool)App::env('ALLOW_UPDATES'),
        'allowAdminChanges' => (bool)App::env('ALLOW_ADMIN_CHANGES'),
        'backupOnUpdate' => (bool)App::env('BACKUP_ON_UPDATE'),
        'devMode' => (bool)App::env('DEV_MODE'),
        'defaultSearchTermOptions' => [
            'subLeft' => true,
            'subRight' => true,
        ],
        'disallowRobots' => true,
        'enableCsrfProtection' => true,
        'generateTransformsBeforePageLoad' => true,
        'omitScriptNameInUrls' => true,
        'securityKey' => App::env('SECURITY_KEY'),
        'maxInvalidLogins' => 1000,
        'maxUploadFileSize' => 20000000,
        'resourceBasePath' => dirname(__DIR__) . '/web/cpresources',
        'maxSlugIncrement' => 100,
        'useEmailAsUsername' => false,
    ],
    'dev' => [

    ],
];
