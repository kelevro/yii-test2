<?php

namespace statical\controllers\backend;

use statical\models\Page;
use statical\models\PageSearch;
use backend\components\Controller;
use statical\components\actions\ImperaviImageUploadAction;

/**
 * PageController implements the CRUD actions for Page model.
 */
class DefaultController extends Controller
{

    public $enableCsrfValidation = false;

    /*** @inheritdoc */
    public function sectionTitle()
    {
        return ['/statical/default/index', 'Pages'];
    }


    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider'  => $dataProvider,
            'searchModel'   => $searchModel,
        ]);
    }

    /**
     * Displays a single Page model.
     * @return mixed
     */
    public function actionView()
    {
        /** @var Page $model */
        $model = $this->loadModel('statical\models\Page');

        $this->pageTitle = $model->title;
        return $this->render('view', ['model' => $model,]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var Page $model */
        $model = $this->loadOrCreateModel('statical\models\Page');

        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = "{$model->title} successful saved";
                return $this->redirect(['index', 'id' => $model->id]);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', ['model' => $model,]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Page $model */
        $model = $this->loadModel('statical\models\Page');

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
            'upload-img' => [
                'class' => ImperaviImageUploadAction::className(),
                'uploadParams' => \Y::param('static_page.images'),
            ],
        ];
    }
}
