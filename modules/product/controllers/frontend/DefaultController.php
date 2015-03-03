<?php

namespace product\controllers\frontend;

use frontend\components\Controller;
use product\search\GeneralSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use product\models\Category;
use product\models\Product;
use product\models\ProductCategory;
use product\search\Searcher;
use product\search\SearchQuery;
use product\search\UserSearch;
use yii\data\ActiveDataProvider;
use frontend\models\Search;
use yii\web\HttpException;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $query = Product::find()->published()->orderByDatesDesc()->active();
        $model = new Product();

        $vals = [];
        if (!empty($_POST['SearchAttr']['size'])) {
            $vals = array_keys($_POST['SearchAttr']['size']);
            $query->hasAttributeValue($vals);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        return $this->render('index', [
            'dataProvider'  => $dataProvider,
            'model'         => $model,
            'valuesIds'     => $vals,
        ]);
    }

    public function actionSearch()
    {
        $us    = new UserSearch();
        $us->load($_POST);
        $us->category = \Y::get('category');
        $hash = $us->getHash();

        if (!SearchQuery::findOne(['hash' => $hash])) {
            $sq = new SearchQuery(['hash' => $hash, 'data' => serialize($us)]);
            $sq->save(false);
        }

        return $this->redirect(['category', 'category' => $us->category, 'hash' => $hash]);
    }

    public function actionGeneralSearch()
    {
        $gs = new GeneralSearch();
        $gs->load($_POST);
        $hash = $gs->getHash();

        if (!SearchQuery::findOne(['hash' => $hash])) {
            $sq = new SearchQuery(['hash' => $hash, 'data' => serialize($gs)]);
            $sq->save(false);
        }

        return $this->redirect(['general-search-result', 'h' => $hash]);
    }

    public function actionGeneralSearchResult()
    {
        $searcher = new Searcher();

        if ($hash = \Y::get('h')) {
            $sq = SearchQuery::findOne(['hash' => $hash]);
            $gs = unserialize($sq->data);
        } else {
            $gs = new GeneralSearch();
        }

        $gs->pageSize = $this->module->params['pageSize'];

        if (\Y::get('page')) {
            $gs->page = \Y::get('page') - 1;
        } else {
            $gs->page = 0;
        }

        $dataProvider = $searcher->generalSearch($gs);

        return $this->render('search', ['dataProvider' => $dataProvider]);
    }

    public function actionCategory()
    {
        if (!$catId = \Y::get('category')) {
            throw new HttpException(404, 'Not Found');
        }

        if ($hash = \Y::get('hash')) {
            $sq = SearchQuery::findOne(['hash' => $hash]);
            $us = unserialize($sq->data);
        } else {
            $us = new UserSearch();
        }

        $us->category = $catId;
        $us->pageSize = $this->module->params['pageSize'];

        $searcher = new Searcher();

        if (\Y::get('page')) {
            $us->page = \Y::get('page') - 1;
        } else {
            $us->page = 0;
        }

        $dataProvider = $searcher->search($us);

        if ($pid = \Y::get('pid')) {
            $page = 1;
            while(1){
                $dataProvider->prepare(true);
                if ($dataProvider->pagination->getPage() > $dataProvider->pagination->pageCount) {
                    break;
                }
                if(in_array($pid, $dataProvider->getKeys())){
                    $page = $dataProvider->pagination->getPage();
                    break;
                }

                $dataProvider->pagination->setPage($dataProvider->pagination->getPage() + 1);
            }
            if ($page >= 1) {
                $dataProvider->pagination->setPage($page);
            }
            unset($_GET['pid']);
        }
        $dataProvider->refresh();

        $category       = Category::findOne(['id' => $catId]);
        $allAttrs       = $category->getAttrsList();

        return $this->render('category', [
            'us'                => $us,
            'dataProvider'      => $dataProvider,
            'allAttrs'          => $allAttrs,
            'category'          => $category,
        ]);
    }

    public function actionCatalog()
    {
        $categories = Category::find()->enabled()->minLvl(2)->maxLvl(2)->orderBy('lft')->all();

        return $this->render('catalog', ['categories' => $categories]);
    }
}
