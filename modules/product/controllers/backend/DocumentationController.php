<?php

namespace product\controllers\backend;

use common\helpers\Storage;
use product\models\Documentation;
use product\models\DocumentationSearch;
use backend\components\Controller;
use yii\web\UploadedFile;

/**
 * DocumentationController implements the CRUD actions for Documentation model.
 */
class DocumentationController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['index', 'Documentations'];
    }


    /**
     * Lists all Documentation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentationSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing Documentation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        ini_set('post_max_size', '64M');
        ini_set('upload_max_filesize', '64M');

        /** @var Documentation $model */
        $model = $this->loadOrCreateModel('product\models\Documentation');

        if ($model->load($_POST)) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $fileName = $model->file->baseName . '.' . $model->file->extension;
                $model->file->saveAs(Storage::getStoragePathTo('documentation') . $fileName);
                $model->link = $fileName;
                if ($model->save()) {
                    $this->flash = "{$model->title} successful saved";
                    if (\Y::get('continue')) {
                        return $this->redirect(['update', 'category' => $model->category_id]);
                    }

                    return $this->redirect(['index']);
                }
            }
            $this->errorFlash = 'Error saving';
        }
        if (\Y::get('category')) {
            $model->category_id = \Y::get('category');
        }

        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Documentation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Documentation $model */
        $model = $this->loadModel('product\models\Documentation');
        $fileName = $model->link;
        if ($model->delete()) {
            unlink(Storage::getStoragePathTo('documentation') . $fileName);
        }

        return $this->redirect(['index']);
    }

    public function actionDocSearchAjax()
    {
        $docs = Documentation::find()
            ->select('id, link AS text')
            ->andWhere('link LIKE :title', [':title' => \Y::get('q').'%'])
            ->limit(100)
            ->asArray()
            ->all();

        $this->endJson(null, [
            'docs' => $docs,
            'total' => count($docs),
        ]);
    }
}
