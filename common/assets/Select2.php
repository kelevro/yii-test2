<?php


namespace common\assets;

use yii\web\AssetBundle;

/**
 * Select 2 asset
 *
 * @package common\assets
 */
class Select2 extends AssetBundle
{
    public $sourcePath = '@common/assets/select2';

    public $js = [
        'select2.js',
    ];

    public $css = [
        'select2.css',
        'select2-bootstrap.css',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}