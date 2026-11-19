<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \CraftCms\Cms\Config\GeneralConfig
 * @link https://craftcms.com/docs/5.x/reference/config/general.html
 */

use CraftCms\Cms\Config\GeneralConfig;

return GeneralConfig::create()
    // Set the default week start day for date pickers (0 = Sunday, 1 = Monday, etc.)
    ->defaultWeekStartDay(1)
    // Preload Single entries as Twig variables
    ->preloadSingles()
    // Prevent user enumeration attacks
    ->preventUserEnumeration()
    // Prevent the front-end Login page
    ->loginPath(false)
    // Set the @webroot alias so the clear-caches command knows where to find CP resources
    ->aliases([
        '@webroot' => public_path(),
    ])
    // Match partial words in searches
    ->defaultSearchTermOptions([
        'subLeft' => true,
        'subRight' => true,
    ])
    ->disallowRobots(true)
    ->useEmailAsUsername(true)
    ->upscaleImages(false)
    ->transformGifs(false)
    // Europa's control panel icon and login page logo
    ->cpIconUrl('/assets/images/cp-icon.svg')
    ->cpLogoUrl('/assets/images/cp-logo.svg')
;
