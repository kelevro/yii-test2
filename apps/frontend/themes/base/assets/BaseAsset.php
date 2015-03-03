<?php


namespace frontend\themes\base\assets;

use yii\web\AssetBundle;

class BaseAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/base/assets';

    public $js = [
    ];

    public $css = [
        'css/style.css',
    ];

    public $depends = [
        'common\assets\App',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}