<?php

namespace modules\demos\fields;

use Craft;
use craft\fields\Link;
use craft\fields\linktypes\BaseTextLinkType;
use craft\helpers\Cp;
use craft\helpers\Html;
use craft\models\Site;

class SiteLink extends BaseTextLinkType
{
    /**
     * @inheritDoc
     */
    public static function id(): string
    {
        return 'siteLink';
    }

    /**
     * @inheritDoc
     */
    public function linkLabel(string $value): string
    {
        return Craft::t('site', 'Site Link');
    }

    public function inputHtml(Link $field, ?string $value, string $containerId): string
    {
        $siteOptions = collect(Craft::$app->getSites()->getAllSites())
        ->map(fn($site) => [
            'label' => Html::encode($site->name),
            'value' => $site->uid,
        ])->all();

        return Cp::selectFieldHtml([
            'name' => 'value',
            'id' => $containerId . '-value',
            'options' => $siteOptions,
            'value' => $value,
            'placeholder' => Craft::t('site', 'Select a site...'),
            'class' => 'fullwidth',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function validateValue(string $value, ?string &$error = null): bool
    {
        $sites = collect(Craft::$app->getSites()->getAllSites());

        return $sites->filter(function(Site $site) use ($value) {
            return $site->uid === $value;
        })->isNotEmpty();
    }

    protected function urlPrefix(): string|array
    {
        return '';
    }

    public function renderValue(string $value): string
    {
        return collect(Craft::$app->getSites()->getAllSites())->firstWhere('uid', $value)->getBaseUrl() ?? '';
    }
}
