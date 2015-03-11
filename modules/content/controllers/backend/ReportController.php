<?php  namespace content\controllers\backend; 

use backend\components\Controller;
use content\models\Author;
use content\models\Book;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

class ReportController extends Controller
{
    public function actionTask1()
    {
        $query = Book::find()->reading()->hasAuthorsCount(3);

        $title = "Task 1";

        $dp = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('books', ['title' => $title, 'dp' => $dp]);
    }

    public function actionTask2()
    {
        $subQuery = (new Query())
            ->select('author_id')
            ->from("plain")
            ->groupBy("author_id")
            ->having([">", new Expression("COUNT(*)"), 3]);

        $query = Author::find()
            ->innerJoin(['p' => $subQuery], "p.author_id = author.id");

        $dp = new ActiveDataProvider([
            'query' => $query,
        ]);

        $title = "Task 2";

        return $this->render('authors', ['title' => $title, 'dp' => $dp]);
    }

    public function actionTask3()
    {
        $query = Book::find()->random();

        $title = "Task 3";

        $dp = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('books', ['title' => $title, 'dp' => $dp]);
    }
}