<?php


namespace backend\controllers;

use backend\components\Controller;
use backend\models\AlertSearch;

/**
 * List of alerts
 * @package backend\controllers
 */
class AlertController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new AlertSearch(\Y::projectId());
        $searchModel->load($_GET);

        $dataProvider = $searchModel->search();

        $this->pageTitle = 'Alerts';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
}