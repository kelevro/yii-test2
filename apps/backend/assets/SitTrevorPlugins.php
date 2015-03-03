<?php


namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Assets for all widgets
 *
 * @package backend\widgets
 */
class SitTrevorPlugins extends AssetBundle
{
    public $sourcePath = '@backend/assets/sir-trevor-plugins';

    public $js = [
        'custom-uploader.js',
        'image.js',
        'main-image.js',
        'unordered-list.js',
        'heading.js',
        'block-quote.js',
        'video.js',
    ];

    public $depends = [
        'common\assets\SirTrevor',
    ];
}