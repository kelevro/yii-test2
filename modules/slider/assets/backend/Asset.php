<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace slider\assets\backend;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@slider/assets/backend';

    public $css = [
        'css/slider.css',
    ];
    public $js = [
    ];
    public $depends = [
        'common\assets\JqueryUI',
        'common\assets\JqueryForm',
        'slider\assets\ModuleAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
