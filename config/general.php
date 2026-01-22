<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here.
 * You can see a list of the default settings in src/config/GeneralConfig.php
 */

use craft\helpers\App;

return [
    'allowUpdates' => false,
    'backupOnUpdate' => false,
    'defaultSearchTermOptions' => [
        'subLeft' => true,
        'subRight' => true,
    ],
    'useEmailAsUsername' => true,
    'backupCommandFormat' => 'custom',
];
