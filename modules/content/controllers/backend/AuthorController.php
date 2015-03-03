<?php

namespace content\controllers\backend;

use content\models\Author;
use content\models\AuthorSeatch;
use backend\components\Controller;
use yii\web\HttpException;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['index', 'Authors'];
    }


    /**
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthorSeatch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var Author $model */
        $model = $this->loadOrCreateModel('content\models\Author');

        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = "{$model->name} successful saved";
                return $this->redirect(['index']);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->name);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Author $model */
        $model = $this->loadModel('content\models\Author');

        $model->delete();

        $this->setFlash("Author deleted successfully");

        return $this->redirect(['index']);
    }

    public function actionSearchAjax()
    {
        if (!\Y::request()->isAjax) {
            throw new HttpException(400);
        }

        $authors = Author::find()
            ->select('id, name AS text')
            ->andWhere('name LIKE :name', [':name' => \Y::get('q').'%'])
            ->limit(100)
            ->asArray()
            ->all();

        $this->endJson(null, [
            'authors' => $authors,
            'total' => count($authors),
        ]);
    }
}
