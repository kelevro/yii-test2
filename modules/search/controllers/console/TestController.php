<?php  namespace search\controllers\console; 

use search\models\AuthorSphinx;
use search\models\BookSphinx;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class TestController extends Controller
{
    public function actionBooks()
    {
        $raw = BookSphinx::find()->match('Eaque sed consectetur et placeat inventore quas beatae voluptate')->all();
        $result = ArrayHelper::map($raw, 'id', function ($model) {
            return [$model['title'], $model['authors_count']];
        });
        print_r($result);
        echo PHP_EOL;
        echo BookSphinx::find()->match('Eaque sed consectetur et placeat inventore quas beatae voluptate')->count(), PHP_EOL;
    }
    public function actionAuthors()
    {
        $raw = AuthorSphinx::find()->match('Pinkie')->orderBy("id desc")->all();
        $ids = ArrayHelper::getColumn($raw, 'id');
        var_dump($ids);
    }
}