<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license MIT
 */

namespace modules\demos\assets\guide;

use craft\web\assets\cp\CpAsset;
use yii\web\AssetBundle;

/**
 * Guide asset bundle
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 */
class GuideAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/dist';

    public $depends = [
        CpAsset::class,
    ];

    public $css = [
        'guide.css',
    ];

    public $js = [
        'guide.js',
    ];
}
