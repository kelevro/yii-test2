<?php


namespace seo\assets;

use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@seo/assets';

    public $js = [
        'js/module.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}