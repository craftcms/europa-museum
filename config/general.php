<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here.
 * You can see a list of the default settings in src/config/GeneralConfig.php
 */

use craft\config\GeneralConfig;
use craft\helpers\App;

return GeneralConfig::create()
    ->omitScriptNameInUrls(true)
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
    ->upscaleImages(false)
;
