<?php


namespace user\assets;

use yii\web\AssetBundle;

class User extends AssetBundle
{
    public $sourcePath = '@user/assets';

    public $js = [
        'js/rbac-manage.js',
    ];

    public $css = [
        'scss/styles.scss',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}