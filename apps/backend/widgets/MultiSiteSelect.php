<?php


namespace backend\widgets;

use common\components\MultiSite;
use yii\base\Widget;


/**
 * Select multisite in admin panel
 *
 * @package backend\widgets
 */
class MultiSiteSelect extends Widget
{
    public function run()
    {
        $list = [];
        /** @var MultiSite $ms */
        foreach (\Y::msManager()->getMultiSites() as $ms) {
            $list[$ms->name] = $ms->getTitle();
        }

        assets\Widgets::register($this->view);
        $selected = \Y::user()->getMultiSiteName();
        echo $this->render('multisite-select', [
            'list'     => $list,
            'selected' => $selected,
        ]);
    }
}