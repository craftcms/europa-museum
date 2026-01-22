<?php

use craft\config\GeneralConfig;

return GeneralConfig::create()
    ->allowUpdates(false)
    ->backupOnUpdate(false)
    ->defaultSearchTermOptions([
        'subLeft' => true,
        'subRight' => true,
    ])
    ->useEmailAsUsername(true)
    ->backupCommandFormat('custom')
    ->omitScriptNameInUrls()
    ->preloadSingles()
    ->preventUserEnumeration()
;
