<?php  namespace content\controllers\backend; 

use backend\components\Controller;
use content\models\Author;
use content\models\Book;
use yii\data\ActiveDataProvider;

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
        $query = Author::find()
            ->innerJoin("author_books ab", "ab.author_id = author.id")
            ->innerJoin("book b", "b.id = ab.book_id")
            ->andWhere(['>', 'users_count', 3]);

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