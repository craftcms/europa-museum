<?php

namespace modules\demos;

use Craft;

use craft\awss3\Volume as AwsVolume;
use craft\volumes\Local as LocalVolume;
use craft\events\RegisterTemplateRootsEvent;
use craft\helpers\App;
use yii\web\Response;
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

        if (!App::env('FS_HANDLE') && !App::env('S3_BUCKET')) {
            putenv('FS_HANDLE=imagesLocal');
            $_SERVER['FS_HANDLE'] = 'imagesLocal';
            $_ENV['FS_HANDLE'] = 'imagesLocal';
        }

        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function (RegisterTemplateRootsEvent $event) {
                $event->roots['modules'] = __DIR__ . '/templates';
            }
        );
    }
}
