<?php

namespace frontend\components;


/**
 * Base controller for frontend
 *
 * @package frontend\components
 */
class Controller extends \common\base\Controller
{

    /**
     * @var \seo\components\Manager
     */
    public $seo;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->seo = \Yii::$app->seo;
        $this->seo->subscribe();

        return true;
    }
}