<?php

namespace content\controllers\backend;

use content\models\Book;
use content\models\BookSearch;
use backend\components\Controller;
use content\models\forms\BookForm;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['index', 'Books'];
    }


    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var Book $book */
        $book = $this->loadOrCreateModel('content\models\Book');

        $model = new BookForm($book);

        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = "{$model->title} successful saved";
                return $this->redirect(['index']);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->book->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Book $model */
        $model = $this->loadModel('content\models\Book');

        $model->delete();
        $this->setFlash("Book deleted successfully");

        return $this->redirect(['index']);
    }
}
