<?php

namespace console\controllers;

use product\models\Category;


class TestController extends \yii\console\Controller
{
    public function actionIndex()
    {
        unlink('/Users/antoxa/web/projects/rk-electronics/storage/products/big/22de048a1c.1.jpg');
    }
}