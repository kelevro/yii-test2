<?php

namespace product;


class Module extends \common\base\Module
{
    public $widgetNamespace     = '\product\widgets\\';
    public $indexWidgetClass    = 'IndexProductsTiles';
    public $title               = 'Products';
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
