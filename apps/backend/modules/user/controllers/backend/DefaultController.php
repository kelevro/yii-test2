<?php


namespace user\controllers\backend;

use user\models\LoginForm;
use backend\components\Controller;

/**
 * Login and logout users
 * User admin rights panel
 *
 * @package user\backend\controllers
 */
class DefaultController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm;

        if ($model->load($_POST) && $model->login()) {
            return $this->goBack(['site/index']);
        }

        $this->layout    = 'login';
        $this->pageTitle = 'Login';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->goHome();
    }
}