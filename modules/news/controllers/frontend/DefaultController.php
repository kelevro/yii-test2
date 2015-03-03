<?php

namespace news\controllers\frontend;

use frontend\components\Controller;
use news\models\News;
use yii\data\ActiveDataProvider;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $query = News::find()->enabled()->orderByDatesDesc();

        if (\Y::get('page')) {
            $page = \Y::get('page') - 1;
        } else {
            $page = 0;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page'              => $page,
                'pageSizeLimit'     => [1, $this->module->params['pageSize']],
                'defaultPageSize'   => $this->module->params['pageSize'],

            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView()
    {
        /** @var \news\models\News $new */
        $new = $this->loadModel('\news\models\News', \Y::request()->get('new'));

        return $this->render('view', [
            'new' => $new,
        ]);
    }

    protected function getDefaultWidgetClass()
    {
        return $this->module->widgetNamespace . $this->module->indexWidgetClass;
    }
}
