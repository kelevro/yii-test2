<?php
/**
 * Created by PhpStorm.
 * User: antoxa
 * Date: 12/24/13
 * Time: 8:20 PM
 */
namespace news\widgets;

use yii\base\Widget;

/**
 * Widget with index news as tiles
 *
 * @package user\widgets
 */
class IndexNewsTiles extends Widget
{
    /**
     * @var \news\models\News[]
     */
    private $news;

    public function init()
    {
        \news\widgets\assets\IndexNewsTilesBundle::register($this->view);

        parent::init();
    }

    public function run()
    {
        echo $this->render('index-news-tiles');
    }

    /**
     * @return \news\models\News[]
     */
    public function getNews()
    {
        return $this->news;
    }
}