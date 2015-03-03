<?php

namespace backend\controllers;

use backend\components\Controller;
use Stringy\Stringy;
use Yii;
use yii\db\Query;

class SiteController extends Controller
{
    public function actionIndex()
    {


        $this->pageTitle = Yii::$app->name;
        return $this->render('index');
    }

    /**
     * Generates slug
     * @ajax
     */
    public function actionGenerateSlug()
    {
        if (($title = \Y::request()->getQueryParam('title')) == null) {
            $this->errorJson('No title');
        }
        $max = \Y::request()->getQueryParam('max', 50);

        $slug = (string)Stringy::create($title)->safeTruncate($max)->slugify();
        $this->endJson('', [
            'slug' => $slug,
        ]);
    }
}
