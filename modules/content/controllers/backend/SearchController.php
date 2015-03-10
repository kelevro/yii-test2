<?php  namespace content\controllers\backend; 

use backend\components\Controller;

class SearchController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}