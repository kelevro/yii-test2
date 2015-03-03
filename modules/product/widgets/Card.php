<?php
namespace product\widgets;

use yii\base\Widget;
use product\assets\CardAsset;

/**
 * Class Card
 *
 * @package frontend\themes\base\widgets
 */
class Card extends Widget
{

    public function init()
    {
        CardAsset::register($this->view);

        parent::init();
    }

    public function run()
    {
        $products = (\Y::session()->get('card'))
            ? \Y::session()->get('card')
            : [];

        return $this->render('card', ['products' => $products]);
    }
}