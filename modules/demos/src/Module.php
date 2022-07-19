<?php

namespace modules\demos;

use Craft;
use craft\anchors\TwigExtension;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\App;
use craft\services\Dashboard;
use craft\web\UrlManager;
use craft\web\View;
use modules\demos\widgets\Guide;
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
            static function (RegisterTemplateRootsEvent $event) {
                $event->roots['modules'] = __DIR__ . '/templates';
            }
        );

        // Register routes for guide
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            static function (RegisterUrlRulesEvent $event) {
                $event->rules['guide'] = ['template' => 'modules/guide/_page'];
                $event->rules['guide/<slug:{slug}>'] = ['template' => 'modules/guide/_page'];
            }
        );

        // Register guide dashboard widget
        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            static function (RegisterComponentTypesEvent $event) {
                $event->types[] = Guide::class;
            }
        );

        // Register anchors extension for guide template views
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Craft::$app->getView()->registerTwigExtension(new TwigExtension());
        }
    }
}
