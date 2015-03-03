<?php

namespace mail\controllers\frontend;

use frontend\components\Controller;
use mail\models\Subscriber;
use mail\ModuleTrait;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * Subscription functions
 *
 * @package mail\controllers\frontend
 */
class DefaultController extends Controller
{
    use ModuleTrait;

    public function actionValidate()
    {
        $subscribe = new Subscriber;
        if (\Y::request()->isAjax) {
            $subscribe->load($_POST);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($subscribe);
        }
    }
    /**
     * Create new subscriber
     */
    public function actionSubscribe()
    {
        $subscribe = new Subscriber;

        if ($subscribe->load($_POST) && $subscribe->save()) {
            $this->endJson('Вы будете получать письма на E-Mail');
        }
        $this->errorJson('Ошибка создания подписки');
    }

    public function actionUnsubscribe()
    {
        $sid = \Y::get('sid');

        $hash = \Y::get('h');

        if (!$sid || !$hash) {
            throw new HttpException(400, 'Not enough params');
        }

        /** @var Subscriber $subscription */
        if (($subscriber = Subscriber::findOne($sid)) == null) {
            throw new HttpException(400, 'Subscription is not found');
        }

        if ($subscriber->hash != $hash) {
            throw new HttpException(400, 'Invalid subscriber');
        }

        $subscriber->disable();

        $this->seo->title = 'Вы отписались от рассылки';
        $this->seo->metaNoIndex = true;
        return $this->render('one');
    }
}
