<?php

namespace news;


class Module extends \common\base\Module
{
    public $widgetNamespace     = '\news\widgets\\';
    public $indexWidgetClass    = 'IndexNewsTiles';
    public $title               = 'News';
    public $params              = [];

    public function init()
    {
        parent::init();
    }

    public function moduleTitle()
    {
        return [null, $this->title];
    }
}
