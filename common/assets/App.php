<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main app asset
 *
 * @package common\assets
 */
class App extends AssetBundle
{
    public $sourcePath = '@common/assets/app';

    public $js = [
        'core.js',
        'jquery.maskedinput/jquery.maskedinput.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\Underscore',
    ];
}