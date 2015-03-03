<?php

namespace news\controllers\backend;

use news\models\News;
use news\models\NewsSearch;
use backend\components\Controller;
use news\components\NewsImageUploadAction;

/**
 * DefaultController implements the CRUD actions for News model.
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    /*** @inheritdoc */
    public function sectionTitle()
    {
        return ['/news/default/index', 'News'];
    }


    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel,]);
    }

    /**
     * Displays a single News model.
     * @return mixed
     */
    public function actionView()
    {
        /** @var News $model */
        $model = $this->loadModel('news\models\News');

        $this->pageTitle = $model->title;
        return $this->render('view', ['model' => $model,]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var News $model */
        $model = $this->loadOrCreateModel('news\models\News');
        if ($model->isNewRecord) {
            $model->is_enabled = true;
            $model->is_sended = false;
        }
        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = "{$model->title} successful saved";
                return $this->redirect(['index']);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', ['model' => $model,]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var News $model */
        $model = $this->loadModel('news\models\News');

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * @inheritdoc
     * @ajax
     */
    public function actions()
    {
        return [
            'upload-main-img' => [
                'class' => NewsImageUploadAction::className(),
                'uploadParams' => $this->module->params['mainImage'],
            ],
            'upload-img' => [
                'class' => NewsImageUploadAction::className(),
                'uploadParams' => $this->module->params['images'],
            ],
        ];
    }
}
