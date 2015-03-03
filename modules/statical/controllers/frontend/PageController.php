<?php

namespace statical\controllers\frontend;


use statical\models\Page;
use yii\web\HttpException;

class PageController extends \common\base\Controller
{

    public function actionView()
    {
        if (!$alias = \Y::get('alias')) {
            throw new HttpException(404, "Param alias can't be empty");
        }

        if (!$page = Page::findByAlias($alias)) {
            throw new HttpException(404, "Page can't be find by alias: $alias");
        }

        return $this->render('view', [
            'model' => $page
        ]);
    }
}
