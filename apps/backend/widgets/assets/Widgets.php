<?php


namespace backend\widgets\assets;

use yii\web\AssetBundle;

/**
 * Assets for all widgets
 *
 * @package backend\widgets
 */
class Widgets extends AssetBundle
{
    public $sourcePath = '@backend/widgets/assets';

    public $js = [
        'js/multisite-select.js'
    ];
}