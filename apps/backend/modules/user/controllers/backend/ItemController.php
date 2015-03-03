<?php

namespace user\controllers\backend;

use user\models\auth\Item;
use user\models\auth\ItemSearch;
use backend\components\Controller;
use Yii;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->checkAccess('user-manage');
        return true;
    }


    /**
    * @inheritdoc
    */
    public function sectionTitle()
    {
        return ['/user/item/index', 'Auth Item'];
    }


	/**
	 * Lists all Item models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new ItemSearch;
		$dataProvider = $searchModel->search($_GET);


        $tasks = Item::getListByType(Item::TASK);
        $roles = Item::getListByType(Item::ROLE);

        \user\assets\User::register($this->view);
        $this->pageTitle = 'List';
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel'  => $searchModel,

            'tasks' => $tasks,
            'roles' => $roles,
		]);
	}


	/**
	 * Updates an existing Item model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionUpdate()
	{
        /** @var Item $model */
        $model = $this->loadOrCreateModel('user\models\auth\Item');

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
	 * Deletes an existing Item model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @return mixed
	 */
	public function actionDelete()
	{
        /** @var Item $model */
        $model = $this->loadModel('user\models\auth\Item');

        if (\Yii::$app->authManager->removeItem($model->name)) {
            $this->flash = "Item '{$model->name}' deleted";
        } else {
            $this->errorFlash = "Error deleting item '{$model->name}'";
        }

        return $this->redirect(['index']);
	}

// ---------------------------------------------------------------------------------------------------------------------
// AUTH ITEM
// ---------------------------------------------------------------------------------------------------------------------

    protected function isValidType($type)
    {
        return in_array($type, [Item::ROLE, Item::TASK, Item::OPERATION]);
    }

    /**
     * List available roles or operations
     *
     * @param int $type
     * @param string $selected role or task name
     * @json
     */
    public function actionList($type, $selected)
    {
        if (!$this->isValidType($type)) {
            $this->errorJson("Invalid type {$type}");
        }

        /** @var Item $model */
        if (!($model = Item::findOne(['type' => ($type + 1), 'name' => $selected]))) {
            $this->errorJson("Type '{$type}' with value {$selected} not found");
        }

        $assigned = $model->getAssignedChildren();
        $notAssigned = $model->getNotAssignedChildren();

        $this->endJson('', [
            'assigned'    => $assigned,
            'notAssigned' => $notAssigned,
        ]);
    }

    /**
     * Assign task to roles or operations to task
     *
     * @param int $type
     * @param string $item
     * @param string $subItem
     * @param string $action assign or remove
     */
    public function actionManageChild($type, $item, $subItem, $action)
    {
        if (!$this->isValidType($type)) {
            $this->errorJson("Invalid type {$type}");
        }
        if (!in_array($action, ['assign', 'remove'])) {
            $this->errorJson("Invalid action {$action}");
        }

        /** @var Item $itemModel */
        if (!($itemModel = Item::findOne(['type' => ($type + 1), 'name' => $item]))) {
            $this->errorJson("Type '{$type}' with value {$item} not found");
        }

        /** @var Item $subItemModel */
        if (!($subItemModel = Item::findOne(['type' => $type, 'name' => $subItem]))) {
            $this->errorJson("Type '{$type}' with value {$subItem} not found");
        }

        if ($action == 'assign') {
            \Yii::$app->authManager->addItemChild($itemModel->name, $subItemModel->name);
        } else {
            \Yii::$app->authManager->removeItemChild($itemModel->name, $subItemModel->name);
        }

        $assigned = $itemModel->getAssignedChildren();
        $notAssigned = $itemModel->getNotAssignedChildren();

        $this->endJson('', [
            'assigned'    => $assigned,
            'notAssigned' => $notAssigned,
        ]);
    }
}
