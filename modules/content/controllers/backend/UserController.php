<?php

namespace content\controllers\backend;

use content\models\User;
use content\models\UserSearch;
use backend\components\Controller;
use yii\web\HttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['index', 'Users'];
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var User $model */
        $model = $this->loadOrCreateModel('content\models\User');

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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var User $model */
        $model = $this->loadModel('content\models\User');

        $model->delete();

        $this->setFlash("User deleted successfully");

        return $this->redirect(['index']);
    }

    public function actionSearchAjax()
    {
        if (!\Y::request()->isAjax) {
            throw new HttpException(400);
        }

        $users = User::find()
            ->select('id, name AS text')
            ->andWhere('name LIKE :name', [':name' => \Y::get('q').'%'])
            ->limit(100)
            ->asArray()
            ->all();

        $this->endJson(null, [
            'users' => $users,
            'total' => count($users),
        ]);
    }
}
