<?php

namespace console\controllers;
use common\parsers\RabotaruCategory;
use job\models\Category;
use user\models\User;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\Console;

/**
 * System utils command
 *
 * @package console\controllers
 */
class UtilsController extends \yii\console\Controller
{
    public function actionCreateUser()
    {
        $this->stdout("Creating user\n");
        $email = $this->prompt('Enter email', [
            'required' => true,
            'validator' => function($email, &$error) {
                $validator = new \yii\validators\EmailValidator();
                if (!$validator->validate($email)) {
                    $error = 'E-Mail is invalid';
                    return false;
                }
                if (User::findOne(['email' => $email])) {
                    $error = 'E-Mail is exist';
                    return false;
                }
                return true;
            },
        ]);
        $pass = $this->prompt('Password', [
            'required' => true,
            'validator' => function($pass, &$error) {
                if (strlen($pass) < 5) {
                    $error = 'Pass min is 6 symbols';
                    return false;
                }
                return true;
            },
        ]);

        $user = new User;
        $user->email = $email;
        $user->password = $pass;
        if ($user->save()) {

            \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole('admin'), $user->id);

            $this->stdout('User created');
        } else {
            $this->stderr('Error creating user');
        }
    }
}