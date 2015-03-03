<?php


namespace seo\controllers\frontend;


use common\base\Controller;
use seo\models\SeoRule;
use yii\web\HttpException;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Controller Seo Data widget
 * @package seo\controllers\frontend
 */
class WidgetController extends Controller
{
    public function beforeAction($action)
    {
        // TODO: check access and rights

        return parent::beforeAction($action);
    }

    public function actionUpdate()
    {
        if (($modelClass = \Y::request()->getQueryParam('model')) == null) {
            throw new HttpException(400, 'Bad request');
        }

        /** @var SeoRule $id */
        if ($id = \Y::request()->getQueryParam('id')) {
            $model = $this->loadModel($modelClass);
        } else {
            $model = new $modelClass;
        }

        if (!$model->load($_POST)) {
            throw new HttpException(400, 'Bad request');
        }

        $model->validate();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->save()) {
            $this->flash = 'Seo Data saved';
        } else {
            $this->errorFlash = 'Error saving seo data';
        }
        return $this->redirect(\Y::request()->referrer);
    }
}