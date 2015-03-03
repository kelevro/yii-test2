<?php


namespace common\base;

/**
 * Base module for all project modules
 * add functional for routing controllers in different application types
 *
 * @package common\components
 */
class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        $path = '@' . $this->id . '/controllers/' . APP_TYPE;
        if (file_exists(\Yii::getAlias($path))) {
            $this->controllerNamespace = '\\' . $this->id . '\controllers\\' . APP_TYPE;
            $this->viewPath = \Yii::getAlias('@' . $this->id . '/views/' . APP_TYPE);
        }

        if (APP_TYPE == 'frontend') {
            // maps module frontend views to theme/modules/module
            $dir = \Yii::getAlias(\Yii::$app->view->theme->basePath . '/modules/'.$this->id);
            \Yii::$app->view->theme->pathMap[$this->viewPath] = [$dir];

            // maps module widget view to theme/modules/module/widget/views
            \Yii::$app->view->theme->pathMap[\Yii::getAlias("@{$this->id}/widgets/views")] = [$dir.DS.'widgets'.DS.'views'];
            //dd(\Yii::$app->view->theme->pathMap);
        }
    }
}