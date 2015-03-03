<?php

namespace product\controllers\backend;

use product\models\Order;
use product\models\OrderSearch;
use backend\components\Controller;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['product/order/list', 'Orders'];
    }


    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new OrderSearch;
        $dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Order model.
     * @return mixed
     */
    public function actionView()
    {
        /** @var Order $model */
        $model = $this->loadModel('product\models\Order');

        $this->pageTitle = 'Order';

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Order model.
     * @return mixed
     */
    public function actionClosed()
    {
        /** @var Order $model */
        $model = $this->loadModel('product\models\Order');

        $model->is_closed = 1;

        $model->load($_POST);

        $model->save(false, ['is_closed']);

        $this->setFlash("Order deleted successfully");

        return $this->redirect(['list']);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Order $model */
        $model = $this->loadModel('product\models\Order');

        $model->is_deleted = 1;

        $model->save(false, ['is_deleted']);

        $this->setFlash("Order deleted successfully");

        return $this->redirect(['list']);
    }
}
