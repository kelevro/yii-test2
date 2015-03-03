<?php

namespace product\controllers\frontend;

use frontend\components\Controller;
use product\models\Category;
use product\models\DocumentationCategory;
use product\models\Product;
use product\models\ProductCategory;
use product\search\Searcher;
use product\search\SearchQuery;
use product\search\UserSearch;
use yii\data\ActiveDataProvider;
use frontend\models\Search;
use yii\web\HttpException;

class documentationController extends Controller
{
    public function actionProduct()
    {
        $product = $this->loadModel('\product\models\Product');

        return $this->render('product', ['product' => $product]);
    }

    public function actionList()
    {
        $docsCat = DocumentationCategory::find()->all();

        return $this->render('documentation', ['docsCat' => $docsCat]);
    }

}
