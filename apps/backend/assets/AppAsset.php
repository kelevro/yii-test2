<?php

namespace backend\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets';

    public $css = [
        'css/bootstrap-overrides.css',
        'css/bootstrap-fix.css',
        'scss/layout.scss',
        'scss/elements.scss',
        'scss/index.scss',
        'scss/tables.scss',
        'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
        'scss/form-showcase.scss',
        'scss/ui-elements.scss',
        'scss/backend.scss',
        'scss/signin.scss',

        'scss/job.scss',
    ];
    public $js = [
        'js/bootstrap.js',
        'js/jquery.knob.js',
        'js/jquery.flot.js',
        'js/jquery.flot.resize.js',
        'js/jquery.flot.stack.js',
        'js/utils.js',
        'js/theme.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}
