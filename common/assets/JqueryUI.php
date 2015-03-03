<?php


namespace common\assets;

use yii\web\AssetBundle;

/**
 * Assets for all widgets
 *
 * @package backend\widgets
 */
class JqueryUI extends AssetBundle
{
    public $sourcePath = '@common/assets/jquery-ui';

    public $css = [
        'css/jquery-ui.css'
    ];
    public $js = [
        'js/jquery-ui.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}