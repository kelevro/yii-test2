<?php


namespace frontend\widgets;

use yii\base\Widget;

class Subscribe extends Widget
{
    public $viewFile = 'subscribe';

    public function run()
    {

        echo $this->render($this->viewFile);
    }
}