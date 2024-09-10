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
        'allowAdminChanges' => true,
        'allowUpdates' => false,
        'backupOnUpdate' => false,
        'defaultSearchTermOptions' => [
            'subLeft' => true,
            'subRight' => true,
        ],
        'disallowRobots' => true,
        'enableCsrfProtection' => true,
        'useEmailAsUsername' => true,
        'omitScriptNameInUrls' => true,
        'maxInvalidLogins' => 1000,
        'maxUploadFileSize' => 20000000,
        'resourceBasePath' => dirname(__DIR__) . '/web/cpresources',
        'maxSlugIncrement' => 100,
        'backupCommandFormat' => 'custom',
    ],
    'dev' => [
        'devMode' => true,
    ],
];
