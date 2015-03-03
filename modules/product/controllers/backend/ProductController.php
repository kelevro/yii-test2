<?php

namespace product\controllers\backend;

use product\components\ImageDeleteAction;
use product\models\Image;
use product\models\Product;
use product\models\ProductSearch;
use backend\components\Controller;
use yii\web\HttpException;
use product\models\forms\ProductUpdate;
use product\components\ImageUploadAction;
use yii\helpers\Url;
use common\helpers\Storage;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['/product/product/list', 'Products'];
    }


    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->search($_GET);
        $this->pageTitle = 'List';
        Url::remember();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionListDeleted()
    {
        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->search($_GET, true);

        $this->pageTitle = 'List Deleted';
        return $this->render('index-deleted', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws
     */
    public function actionUpdate()
    {
        /** @var Product $model */
        $model = $this->loadOrCreateModel('product\models\Product');
        if ($model->isNewRecord) {
            if (($category = \Y::get('category')) == null) {
                throw new HttpException(400, 'Bad request');
            }
            $model->category_id = $category;
        }
        $formModel = new ProductUpdate($model);

        if ($formModel->load($_POST)) {
            if ($formModel->save()) {
                $this->flash = "{$formModel->title} successful saved";

                if ($url = Url::previous()) {
                    $resultUrl = [parse_url($url, PHP_URL_PATH)];
                    $page = 0;
                    if ($query = parse_url($url, PHP_URL_QUERY)) {
                        $params = explode('&', urldecode($query));
                        foreach ($params as $idx => $param) {
                            $val = explode('=', $param);
                            if (!empty($val)) {
                                $resultUrl[$val[0]] = $val[1];
                            }

                        }
                    }
                    $resultUrl['rid']  = $formModel->product->id;
                    $resultUrl['#']    = "row_{$formModel->product->id}";
                } else {
                    $resultUrl = ['list'];
                }

                return $this->redirect($resultUrl);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', [
            'model' => $formModel,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Product $model */
        $model = $this->loadModel('product\models\Product');

        $model->is_deleted = 1;

        $model->save(false, ['is_deleted']);

        $this->setFlash("Product #{$model->id} deleted successfully");

        return $this->redirect(['list']);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionRestore()
    {
        /** @var Product $model */
        $model = $this->loadModel('product\models\Product');

        $model->is_deleted = 0;

        $model->save(false, ['is_deleted']);

        $this->setFlash("Product #{$model->id} restored successfully");

        return $this->redirect(['list-deleted']);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDeleteForever()
    {
        /** @var Product $model */
        $model = $this->loadModel('product\models\Product');

        $model->delete();

        $this->setFlash("Product #{$model->id} deleted successfully");

        return $this->redirect(['list-deleted']);
    }

    /**
     * @inheritdoc
     * @ajax
     */
    public function actions()
    {
        return [
            'upload-image' => [
                'class'         => ImageUploadAction::className(),
                'uploadParams'  => $this->module->params['mainImage'],
            ],
            'delete-image' => [
                'class'         => ImageDeleteAction::className(),
                'uploadParams'  => $this->module->params['mainImage'],
                'imageId'       => \Y::get('image'),
            ],
        ];
    }

    public function actionLoadImages()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = ['files' => []];
        if (!$productId = \Y::get('product')) {
            return $result;
        }
        /** @var Image[] $images */
        if (!$images = Image::find()->andWhere(['product_id' => $productId])->all()) {
            return $result;
        }
        foreach ($images as $id => $image) {
            $result['files'][$id] = [
                'deleteType'    => "GET",
                'deleteUrl'     => Url::toRoute(['/product/product/delete-image', 'image' => $image->id]),
                'thumbnailUrl'  => Storage::getStorageUrlTo('/product/xsmall') . DS . $image->img,
                'name'          => $image->img,
                'size'          => $image->size,
                'type'          => $image->extension,
                'modelId'       => $image->id,
                'title'         => $image->title,
                'alt'           => $image->alt,
                'url'           => Storage::getStorageUrlTo('/product/medium') . DS . $image->img,
            ];
        }

        return $result;
    }

    public function actionRelatedSearchAjax()
    {
        $products = Product::find()
            ->select('id, title AS text')
            ->andWhere('title LIKE :title', [':title' => \Y::get('q').'%'])
            ->limit(100)
            ->asArray()
            ->all();

        $this->endJson(null, [
            'products' => $products,
            'total' => count($products),
        ]);
    }
}
