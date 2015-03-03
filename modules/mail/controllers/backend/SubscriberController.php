<?php

namespace mail\controllers\backend;

use mail\models\Subscriber;
use mail\models\SubscriberSearch;
use backend\components\Controller;

/**
 * SubcriberController implements the CRUD actions for Subscriber model.
 */
class SubscriberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['url alias here', 'SubcriberController'];
    }


    /**
     * Lists all Subscriber models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubscriberSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Subscriber model.
     * @return mixed
     */
    public function actionView()
    {
        /** @var Subscriber $model */
        $model = $this->loadModel('mail\models\Subscriber');

        $this->pageTitle = $model->title;
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Subscriber model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var Subscriber $model */
        $model = $this->loadOrCreateModel('mail\models\Subscriber');

        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = "{$model->email} successful saved";
                return $this->redirect(['index']);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->email);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Subscriber model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Subscriber $model */
        $model = $this->loadModel('mail\models\Subscriber');

        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionEnabled()
    {
        /** @var Subscriber $model */
        $model = $this->loadModel('mail\models\Subscriber');

        $model->is_enabled = 1;

        $model->save(false, ['is_enabled']);

        return $this->redirect(['index']);
    }

    public function actionDisabled()
    {
        /** @var Subscriber $model */
        $model = $this->loadModel('mail\models\Subscriber');

        $model->is_enabled = 0;

        $model->save(false, ['is_enabled']);

        return $this->redirect(['index']);
    }
}
