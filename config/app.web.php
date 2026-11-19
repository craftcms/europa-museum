<?php
/**
 * This file contributes additional config for HTTP requests.
 * 
 * The `session` component should only be configured here!
 * @see https://craftcms.com/docs/5.x/reference/config/app.html
 */

return [
    'components' => [
        'session' => function() {
            // The demos live on special infrastructure that can’t rely on file-based sessions.
            // (You probably don’t need to worry about this in other projects!)

            // Get the default component config:
            $config = craft\helpers\App::sessionConfig();

            // Override the class to use DB session class:
            $config['class'] = yii\web\DbSession::class;

            // Set the session table name:
            $config['sessionTable'] = craft\db\Table::PHPSESSIONS;

            // Return the initialized component:
            return Craft::createObject($config);
        },
    ],
];
