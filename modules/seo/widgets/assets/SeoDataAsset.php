<?php


namespace seo\widgets\assets;

use yii\web\AssetBundle;

class SeoDataAsset extends AssetBundle
{
    public $sourcePath = '@seo/widgets/assets';

    public $js = [
        'seo-data-backend.js',
    ];

    public $css = [
        'seo-data.scss',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}