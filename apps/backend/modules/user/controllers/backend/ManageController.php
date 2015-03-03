<?php

namespace user\controllers\backend;

use user\models\User;
use user\models\UserSearch;
use backend\components\Controller;
use yii\web\HttpException;

/**
 * ManageController implements the CRUD actions for User model.
 */
class ManageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['/user/manage/index', 'Users'];
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->checkAccess(['user-manage', 'content-editor']);

        $searchModel = new UserSearch(\Y::multisite()->getProjectId());
        $role = null;
        if (!$this->hasAccess('user-manage')) {
            $role = 'content-copywriter';
        }
        $dataProvider = $searchModel->search($_GET, $role);

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
        $this->checkAccess(['user-manage', 'content-editor']);

        /** @var \user\models\User $model */
        $model = $this->loadOrCreateModel('\user\models\User');
        $model->scenario = 'admin';

        if (!$model->isNewRecord
            && !$this->hasAccess('user-manage')
            && array_keys($model->getAssignedRoles()) != ['content-copywriter']) {
            throw new HttpException(403, 'No permission');
        }

        if ($model->load($_POST)) {
            if ($model->isNewRecord) {
                $model->project_id = \Y::multisite()->getProjectId();
            }
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        $this->checkAccess('user-manage');
        /** @var User $model */
        $model = $this->loadModel('User');

        $model->delete();

        return $this->redirect(['index']);
    }
}
