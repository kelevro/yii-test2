<?php
namespace frontend\controllers;

use frontend\components\Controller;
use news\models\News;
use product\models\Product;
use Yii;
use frontend\models\forms\FrontUser;
use frontend\models\Callback;
use frontend\models\Stock;
use frontend\models\Order;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Радиокомпонеты';
        $news = News::find()->enabled()->orderByDatesDesc()->limit(3)->all();
        return $this->render('index', [
            'news' => $news
        ]);
    }

    public function actionContacts()
    {
        $this->view->title = 'Контакты. Радиокомпоненты';
        return $this->render('contacts');
    }

    /**
     * Render error page
     */
    public function actionError()
    {
        $view = '500';
        if (\Yii::$app->errorHandler->exception instanceof HttpException) {
            $code = \Yii::$app->errorHandler->exception->statusCode;
            if ($code >= 400 && $code <= 499) {
                $view = '404';
                $this->seo->title = 'Ошибка ' . $code;
            }
        }

        if ($view == '500') {
            $this->seo->title = 'Внутренняя ошибка сервера';
        }

        return $this->render($view);
    }
}
