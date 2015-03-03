<?php

namespace console\controllers;

use news\models\News;
use mail\models\Subscriber;
use yii\base\Exception;


class MailSendController extends \yii\console\Controller
{
    public $log = 'mail/news';

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        \Yii::$app->urlManager->setBaseUrl('http://'.\Y::param('domains.frontend'));

        return true;
    }
    public function actionNews()
    {
        /** @var News $new */
        if (!$new  = News::find()->notSended()->one()) {
            \L::trace("Nothing to send", $this->log);
            return false;
        }

        \L::trace("Send new #{$new->id}", $this->log);

        try {
            /** @var Subscriber[] $subscribers */
            if (!$subscribers = Subscriber::find()->enabled()->all()) {
                \L::trace("Don't have subscribers for send", $this->log);
                return false;
            }

            $count = 0;
            foreach ($subscribers as $subscriber) {
                \L::trace("Send new for subscriber #{$subscriber->id}", $this->log);
                \Yii::$app->mail->compose('new', ['new' => $new, 'subscriber' => $subscriber])
                    ->setFrom(\Y::param('fromEmail'))
                    ->setTo($subscriber->email)
                    ->setSubject($new->title)
                    ->send();
                $count++;
            }
        } catch (Exception $e) {
            \L::error($e->getMessage(), $this->log);
            return false;
        }
        $new->is_sended = 1;
        $new->save(false, ['is_sended']);

        \L::success("Send new #{$new->id} successfully finished", $this->log);
        \L::success("Sended {$count} mails", $this->log);
        return true;
    }
}