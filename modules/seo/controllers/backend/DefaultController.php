<?php


namespace seo\controllers\backend;

use backend\components\Controller;
use seo\models\SeoRulesSearch;
use yii\web\HttpException;

/**
 * Manage seo rules
 * @package seo\controllers\backend
 */
class DefaultController extends Controller
{
    /**
     * List seo rules
     */
    public function actionIndex()
    {
        $searchModel = new SeoRulesSearch(\Y::multisite()->getProjectId());
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'Seo rules';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Create and edit seo rule
     */
    public function actionUpdate()
    {
        if ($id = \Y::request()->getQueryParam('id')) {
            $model = $this->loadModel('\seo\models\SeoRule');
        } else {
            $modelClass = null;
            if (!$id && ($modelClass = \Y::request()->getQueryParam('model')) == null) {
                throw new HttpException(400, 'Bad request');
            }

            if (!$id && !in_array($modelClass, $this->module->ruleModels)) {
                throw new HttpException(400, 'Bad request');
            }

            $model = new $modelClass;
        }

        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = 'Rule saved';
                return $this->redirect(['index']);
            }
            $this->errorFlash = 'Error saving rule';
        }

        $this->pageTitle = $model->isNewRecord ? 'Create new rule' : 'Update rule';
        return $this->render('update', [
            'model' => $model,
        ]);

    }
}