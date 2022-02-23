<?php

namespace modules\demos;

use Craft;

use craft\anchors\TwigExtension;
use craft\awss3\Volume as AwsVolume;
use craft\volumes\Local as LocalVolume;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\helpers\App;
use craft\services\Dashboard;
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

        if (App::env('CRAFT_USE_LOCAL_VOLUMES')) {
            $this->_useLocalVolumes();
        }

        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            static function (RegisterTemplateRootsEvent $event) {
                $event->roots['modules'] = __DIR__ . '/templates';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            static function (RegisterUrlRulesEvent $event) {
                $event->rules['guide'] = ['template' => 'modules/guide/_page'];
                $event->rules['guide/<slug:{slug}>'] = ['template' => 'modules/guide/_page'];
            }
        );

        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            static function (RegisterComponentTypesEvent $event) {
                $event->types[] = Guide::class;
            }
        );

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Craft::$app->getView()->registerTwigExtension(new TwigExtension());
        }
    }

    private function _useLocalVolumes()
    {
        Craft::$container->set(AwsVolume::class, function ($container, $params, $config) {
            if (empty($config['id'])) {
                return new AwsVolume($config);
            }

            return new LocalVolume([
                'id' => $config['id'],
                'uid' => $config['uid'],
                'name' => $config['name'],
                'handle' => $config['handle'],
                'hasUrls' => $config['hasUrls'],
                'url' => "@web/{$config['subfolder']}",
                'path' => "@webroot/{$config['subfolder']}",
                'sortOrder' => $config['sortOrder'],
                'dateCreated' => $config['dateCreated'],
                'dateUpdated' => $config['dateUpdated'],
                'fieldLayoutId' => $config['fieldLayoutId'],
            ]);
        });
    }
}
