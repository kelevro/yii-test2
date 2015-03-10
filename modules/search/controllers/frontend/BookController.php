<?php  namespace search\controllers\frontend;

use search\models\BookSearch;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class BookController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors'  => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age' => 86400,
                ]
            ],
        ], parent::behaviors());
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];


    public function actionIndex()
    {
        $searchModel = new BookSearch;
        return $searchModel->search(\Y::request()->getQueryParams());
    }

}