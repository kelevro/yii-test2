<?php

namespace product\controllers\backend;

use product\models\Attribute;
use product\models\Category;
use product\models\CategorySearch;
use backend\components\Controller;
use yii\web\HttpException;
use common\components\actions\ImageUploadAction;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    /**
     * @inheritdoc
     */
    public function sectionTitle()
    {
        return ['/product/category/list', 'Categories'];
    }


    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionList()
    {
        $categories = Category::find()->orderBy('lft')->all();

        $this->pageTitle = 'List';
        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    public function actionUpdate()
    {
        /** @var Category $category */
        $category = $this->loadOrCreateModel('\product\models\Category');
        if ($category->isNewRecord && !\Y::get('pid')) {
            throw new HttpException(400, 'Bad Request');
        }
        /** @var Category $parent */
        $parent = $category->isNewRecord
            ? $this->loadModel('\product\models\Category', \Y::get('pid'))
            : $category->parent()->one();

        if ($category->load($_POST)) {
            $hasDirty = $category->dirtyAttributes;
            if ($category->isNewRecord) {
                $res = $category->appendTo($parent);
            } else {
                $res = $category->saveNode();
            }

            if ($res || (!$res && (!$hasDirty || $hasDirty == ['is_enabled' => '1']))) {
                $this->setFlash('Successful saved');
                return $this->redirect(['/product/category/list']);
            }
            $this->setErrorFlash('Error saving');
        }

        if ($category->isNewRecord) {
            $categories = Category::findOne($parent->id)->ancestors()->select('id')->column();
            $categories = array_merge($categories, [$parent->id]);
        } else {
            $categories = Category::findOne($category->id)->ancestors()->select('id')->column();
            $categories = array_merge($categories, [$category->id]);
        }
        /** @var Attribute[] $attributes */
        $attrs = Attribute::find()->category($categories)->all();

        $this->pageTitle = $category->isNewRecord ? 'Create category' : 'Edit category';
        $category->seoData->enabled = true;
        return $this->render('update', [
            'model'     => $category,
            'parent'    => $parent,
            'attrs'     => $attrs,
        ]);
    }

    public function actionUp()
    {
        $category = $this->loadModel('\product\models\Category');
        $node = $category->prev()->one();
        if (empty($node)) {
            return $this->redirect(['/product/category/list']);
        }
        $category->moveBefore($node);
        return $this->redirect(['/product/category/list']);
    }

    public function actionDown()
    {
        $category = $this->loadModel('\product\models\Category');
        $node = $category->next()->one();
        if (empty($node)) {
            return $this->redirect(['/product/category/list']);
        }
        $category->moveAfter($node);
        return $this->redirect(['/product/category/list']);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        /** @var Category $model */
        $model = $this->loadModel('product\models\Category');

        $model->deleteNode();

        return $this->redirect(['list']);
    }

    /**
     * @inheritdoc
     * @ajax
     */
    public function actions()
    {
        return [
            'upload-main-img' => [
                'class' => ImageUploadAction::className(),
                'uploadParams' => $this->module->params['categoryImage'],
            ],
        ];
    }
}
