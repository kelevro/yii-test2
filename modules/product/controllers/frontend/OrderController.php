<?php

namespace product\controllers\frontend;

use product\models\Product;
use product\models\forms\OrderCreate;
use frontend\components\Controller;

class OrderController extends Controller
{
    public function actionCreate()
    {
        $model = new OrderCreate();
        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->setFlash('Ваш заказ успешно создан');
                \Y::session()->remove('card');
                $this->sendEmails($model);
                return $this->redirect(['/catalog']);
            }
            $this->setErrorFlash('Ошибка при создании заказа');
        }

        $card = \Y::session()->get('card');

        if (empty($card['products'])) {
            $this->setErrorFlash('Ваша корзина пуста');
            return $this->redirect(['/catalog']);
        }
        $products  = $model->processProductByCard($card['products']);

        return $this->render('create', [
            'model'         => $model,
            'products'      => $products,
        ]);
    }

    protected function sendEmails(OrderCreate $model)
    {
        \Yii::$app->mail->compose('order', ['order' => $model->order])
            ->setFrom(\Y::param('fromEmail'))
            ->setTo($model->email)
            ->setSubject("Новый заказ")
            ->send();

        \Yii::$app->mail->compose('order-self', [
            'order'     => $model->order,
            'userName'  => $model->username,
            'phone'     => $model->phone,
            'email'     => $model->email,

        ])
            ->setFrom(\Y::param('fromEmail'))
            ->setTo(\Y::param('sellerEmail'))
            ->setSubject("Номер закза №{$model->order->id}")
            ->send();
    }
}
