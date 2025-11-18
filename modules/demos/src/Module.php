<?php

namespace modules\demos;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\helpers\App;
use craft\web\View;
use yii\base\Event;

class Module extends \yii\base\Module
{
    public function init(): void
    {
        Craft::setAlias('@modules/demos', __DIR__);

        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            $this->controllerNamespace = 'modules\\demos\\console\\controllers';
        } else {
            $this->controllerNamespace = 'modules\\demos\\controllers';
        }

        parent::init();

        // Backfill the `UPLOAD_FS` variable, as it determines how assets are handled:
        $fsHandle = App::env('UPLOAD_FS') ?? (App::env('S3_BUCKET') ? 'remote' : 'local');
        putenv("UPLOAD_FS=$fsHandle");
        $_SERVER['UPLOAD_FS'] = $fsHandle;
        $_ENV['UPLOAD_FS'] = $fsHandle;

        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function (RegisterTemplateRootsEvent $event) {
                $event->roots['modules'] = __DIR__ . '/templates';
            }
        );
    }
}
