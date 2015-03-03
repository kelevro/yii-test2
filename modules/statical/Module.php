<?php

namespace statical;


class Module extends \common\base\Module
{
    public $title               = 'Static';

    public function init()
    {
        parent::init();
    }

    public function moduleTitle()
    {
        return [null, $this->title];
    }
}
