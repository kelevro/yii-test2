<?php


namespace backend\widgets;

use yii\base\Widget;

/**
 * Left side menu
 *
 * @package backend\widgets
 */
class SideBar extends Widget
{
    public $config = '@backend/config/menu.php';

    public function run()
    {
        $menu = require \Yii::getAlias($this->config);
        $items = [];
        foreach ($menu as $item) {
            if (!empty($item['access']) && !$this->checkAccess($item['access'])) {
                continue;
            }

            if (!empty($item['subitems'])) {
                $subItems = [];
                foreach ($item['subitems'] as $subItem) {
                    if (!empty($subItem['access']) && !$this->checkAccess($subItem['access'])) {
                        continue;
                    }
                    $subItems[] = $subItem;
                }
                $item['subitems'] = $subItems;
            }
            $items[] = $item;
        }
        echo $this->render('sidebar', [
            'items' => $items,
        ]);
    }

    protected function checkAccess($ops)
    {
        foreach ($ops as $accessItem) {
            if (\Y::hasAccess($accessItem)) {
                return true;
            }
        }
        return false;
    }

}