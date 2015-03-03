<?php

namespace slider\widgets;

use yii\base\Widget;
use slider\models\Slider as SliderModel;

/**
 * Widget with index product as tiles
 *
 * @package product\widgets
 */
class Slider extends Widget
{
    public $viewFile = 'slider';

    public function init()
    {
        \slider\assets\frontend\Asset::register($this->view);

        parent::init();
    }

    public function run()
    {
        $sliders = SliderModel::find()->sortByWeight()->all();

        return $this->render($this->viewFile, [
            'sliders' => $sliders,
        ]);
    }
}