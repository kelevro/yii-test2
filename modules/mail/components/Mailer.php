<?php
namespace common\base;

use yii\swiftmailer\Mailer as MailerBase;

class Mailer extends MailerBase
{

    public function getView()
    {
        $view = parent::getView();

        $view->theme = \Yii::createObject(\Y::multisite()->theme);

        $this->setView($view);

        return parent::getView();
    }
}