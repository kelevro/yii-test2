<?php

namespace seo\widgets;

use seo\models\SeoRule;
use seo\Module;
use seo\widgets\assets\SeoDataAsset;
use yii\base\Widget;

/**
 * Widget for edit seo data from frontend
 *
 * @package seo\widgets
 */
class SeoData extends Widget
{
    /**
     * Render widget
     */
    public function run()
    {
        /** @var Module $module */
        $module = \Yii::$app->getModule('seo');
        $route = \Yii::$app->controller->route;

        if (($modelClass = $module->findModelClassForRoute($route)) == null) {
            return;
        }

        /** @var SeoRule $model */
        if (($model = $modelClass::findByRoute($route, SeoRule::filterParams($modelClass, $_GET))) == null) {
            $model = new $modelClass;
            $model->route = \Yii::$app->controller->route;
            $model->loadRouteParams($_GET);
        }

        SeoDataAsset::register($this->view);
        echo $this->render('seo-data', [
            'model'   => $model,
            'hasData' => !$model->isNewRecord,
        ]);
    }

}