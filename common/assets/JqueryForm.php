<?php


namespace common\assets;

use yii\web\AssetBundle;

/**
 * Assets for all widgets
 *
 */
class JqueryForm extends AssetBundle
{
    public $sourcePath = '@common/assets/jquery-form';

    public $js = [
        'js/jquery.form.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}