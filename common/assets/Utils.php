<?php


namespace common\assets;

use yii\web\AssetBundle;

/**
 * Asset for form submitter
 *
 * @package common\assets
 */
class Utils extends AssetBundle
{
    public $sourcePath = '@common/assets/utils';

    public $js = [
        'js/form.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}