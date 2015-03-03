<?php


namespace news\widgets\assets;

use yii\web\AssetBundle;

/**
 * Assets for all widgets
 *
 * @package news\widgets
 */
class IndexNewsTilesBundle extends AssetBundle
{
    public $sourcePath = '@news/widgets/assets/index-news-tiles';

    public $css = [
        'less/temp.less'
    ];

}