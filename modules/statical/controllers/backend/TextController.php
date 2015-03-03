<?php

namespace statical\controllers\backend;

use statical\models\Text;
use statical\models\TextSearch;
use backend\components\Controller;

/**
 * TextController implements the CRUD actions for Text model.
 */
class TextController extends Controller
{

    /*** @inheritdoc */
    public function sectionTitle()
    {
        return ['/statical/text/index', 'Texts'];
    }


    /**
     * Lists all Text models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TextSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing Text model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var Text $model */
        $model = $this->loadOrCreateModel('statical\models\Text');

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
     * Deletes an existing Text model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Text $model */
        $model = $this->loadModel('statical\models\Text');

        $model->delete();

        return $this->redirect(['index']);
    }
}
