<?php

namespace product\controllers\backend;

use product\models\forms\AttributeUpdate;
use product\models\Attribute;
use product\models\AttributeSearch;
use backend\components\Controller;

/**
 * AttributeController implements the CRUD actions for Attribute model.
 */
class AttributeController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['/product/attribute/list', 'Attributes'];
    }


    /**
     * Lists all Attribute models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new AttributeSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing Attribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var Attribute $model */
        $model = $this->loadOrCreateModel('product\models\Attribute');

        $formModel = new AttributeUpdate($model);

        if ($formModel->load($_POST)) {
            if ($formModel->save()) {
                $this->flash = "{$model->title} successful saved";
                return $this->redirect(['list']);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', [
            'model' => $formModel,
        ]);
    }

    /**
     * Deletes an existing Attribute model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Attribute $model */
        $model = $this->loadModel('product\models\Attribute');

        $model->delete();

        return $this->redirect(['list']);
    }
}
