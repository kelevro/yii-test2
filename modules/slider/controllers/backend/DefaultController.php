<?php

namespace slider\controllers\backend;

use slider\models\Slider;
use backend\components\Controller;
use slider\components\SliderImageUploadAction;

/*** DefaultController implements the CRUD actions for Slider model.*/
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    /*** @inheritdoc */
    public function sectionTitle()
    {
        return ['/slider/default/index', 'Sliders'];
    }


    /**    * Lists all Slider models.    * @return mixed */
    public function actionIndex()
    {
        $images = Slider::find()->sortByWeight()->all();

        $model  = new Slider();

        if (!empty($_POST['is_post'])) {
            $model->deleteAll();
            if (!empty($_POST['Slider'])) {
                foreach ($_POST['Slider'] as $id => $file) {
                    $model = new Slider();
                    $model->image   = $file['image'];
                    $model->url     = $file['url'];
                    $model->alt     = $file['alt'];
                    $model->title   = $file['title'];
                    $model->weight  = $file['weight'];
                    $model->save();
                    unset($model);
                }
            }
            $this->redirect('/slider/default/index');
        }



        $this->pageTitle = 'List images';

        return $this->render('index', [
            'images' => $images,
        ]);
    }

    /**    * Displays a single Slider model.    * @return mixed */
    public function actionView()
    {
        /** @var Slider $model */
        $model = $this->loadModel('slider\models\Slider');

        $this->pageTitle = $model->title;
        return $this->render('view', ['model' => $model,]);
    }

    /**    * Updates an existing Slider model.    * If update is successful, the browser will be redirected to the 'view' page.    * @return mixed */
    public function actionUpdate()
    {
        /** @var Slider $model */
        $model = $this->loadOrCreateModel('slider\models\Slider');

        if ($model->load($_POST)) {
            if ($model->save()) {
                $this->flash = "{$model->title} successful saved";
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', ['model' => $model,]);
    }

    /**    * Deletes an existing Slider model.    * If deletion is successful, the browser will be redirected to the 'index' page.    * @return mixed */
    public function actionDelete()
    {
        /** @var Slider $model */
        $model = $this->loadModel('slider\models\Slider');

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
                'class' => SliderImageUploadAction::className(),
                'uploadParams' => $this->module->images,
            ],
        ];
    }
}
