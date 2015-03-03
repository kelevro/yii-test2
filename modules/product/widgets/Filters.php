<?php

namespace product\widgets;

use yii\base\Widget;
use \product\assets\FiltersAsset;
use product\models\Category;
use product\search\UserSearch;

/**
 * Widget with index product as tiles
 *
 * @package product\widgets
 */
class Filters extends Widget
{
    /** @var \product\models\Category */
    public $category;

    public $viewFile = 'filters';

    /** @var UserSearch */
    public $us;

    public function init()
    {
        FiltersAsset::register($this->view);

        parent::init();
    }

    public function run()
    {
        if (!$this->category && !($this->category instanceof Category)) {
            return null;
        }

        $attrs = $this->category->getAttrs();

        if (!$attrs) {
            return null;
        }

        return $this->render($this->viewFile, [
            'attrs'     => $attrs,
            'us'        => $this->us,
            'category'  => $this->category,
        ]);
    }
}