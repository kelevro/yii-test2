<?php

namespace product\controllers\backend;

use product\models\DocumentationCategory;
use product\models\DocumentationCategorySearch;
use backend\components\Controller;

/**
 * DocumentationCategoryController implements the CRUD actions for DocumentationCategory model.
 */
class DocumentationCategoryController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['url alias here', 'DocumentationCategoryController'];
    }


    /**
     * Lists all DocumentationCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentationCategorySearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing DocumentationCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var DocumentationCategory $model */
        $model = $this->loadOrCreateModel('product\models\DocumentationCategory');

        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = "{$model->title} successful saved";
                return $this->redirect(['list']);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumentationCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var DocumentationCategory $model */
        $model = $this->loadModel('product\models\DocumentationCategory');

        $model->delete();

        return $this->redirect(['index']);
    }
}
