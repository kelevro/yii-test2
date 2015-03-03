<?php
namespace frontend\controllers;

use frontend\components\Controller;
use news\models\News;
use Yii;
use frontend\models\forms\FrontUser;
use frontend\models\Callback;
use frontend\models\Stock;
use frontend\models\Order;

/**
 * Site controller
 */
class StaticController extends Controller
{
    public function actionBrands()
    {
        $this->view->title = 'Brands';
        return $this->render('brands');
    }
}
