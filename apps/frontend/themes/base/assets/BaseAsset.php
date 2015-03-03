<?php


namespace frontend\themes\base\assets;

use yii\web\AssetBundle;

class BaseAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/base/assets';

    public $js = [
        'js/blueimp-gallery.min.js'
    ];

    public $css = [
//        'css/fonts/fonts.css',
        'css/default.css',
        'css/style.css',
        'css/blueimp-gallery.min.css',
    ];

    public $depends = [
        'common\assets\App',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}