<?php

namespace slider;


class Module extends \common\base\Module
{
    public $title  = 'News';

    public $images = [];

    public function init()
    {
        parent::init();
    }

    public function moduleTitle()
    {
        return [null, $this->title];
    }
}
