<?php


namespace common\assets;

use yii\web\AssetBundle;

/**
 * Underscore.js asset
 *
 * @package common\assets
 */
class Underscore extends AssetBundle
{
    public $sourcePath = '@common/assets/underscore';

    public $js = [
        'underscore.js',
    ];
}