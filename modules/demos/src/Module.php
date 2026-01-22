<?php

namespace modules\demos;

use Craft;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\fields\Link;
use craft\helpers\App;
use craft\web\View;
use modules\demos\fields\SiteLink;
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

        $fsHandle = App::env('FS_HANDLE') ?? (App::env('S3_BUCKET') ? 'images' : 'imagesLocal');
        putenv("FS_HANDLE=$fsHandle");
        $_SERVER['FS_HANDLE'] = $fsHandle;
        $_ENV['FS_HANDLE'] = $fsHandle;

        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function (RegisterTemplateRootsEvent $event) {
                $event->roots['modules'] = __DIR__ . '/templates';
            }
        );

        Event::on(Link::class, Link::EVENT_REGISTER_LINK_TYPES, function(RegisterComponentTypesEvent $event) {
            $event->types[] = SiteLink::class;
        });
    }
}
