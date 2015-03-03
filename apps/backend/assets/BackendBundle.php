<?php


namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Assets for all widgets
 *
 * @package backend\widgets
 */
class BackendBundle extends AssetBundle
{
    public $sourcePath = '@backend/assets/backend';

    public $js = [
        'js/jquery.form.min.js'
    ];

    public $depends = [
        'backend\config\AppAsset',
    ];
}