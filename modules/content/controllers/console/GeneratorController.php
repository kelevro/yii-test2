<?php  namespace content\controllers\console; 

use content\models\Author;
use content\models\Book;
use content\models\User;
use Faker\Factory;
use yii\console\Controller;

class GeneratorController extends Controller
{
    public function init()
    {
        ini_set('memory_limit','4000M');
    }
    public function actionAuthors()
    {
        for ($i = 0; $i < 2500; $i++) {

            $data = [];
            $faker = Factory::create();

            \Y::db()->open();
            $dbc = \Y::db()->createCommand();

            for ($j = 0; $j < 100000; $j++) {
                $data[] = [$faker->name];
            }
            $dbc->batchInsert('author', ['name'], $data)->execute();

            \Y::db()->close();

            unset($faker);
            unset($data);
            unset($dbc);

            \L::success("Finished butch {$i}");
        }
    }

    public function actionUsers()
    {
        $faker = Factory::create();

        $dbc = \Y::db()->createCommand();
        for ($i = 0; $i < 100; $i++) {
            $data = [];
            for ($j = 0; $j < 10000; $j++) {
                $data[] = [$faker->userName];
            }
            $dbc->batchInsert('user', ['name'], $data)->execute();
            \L::success("Finished butch {$i}");
        }
    }

    public function actionBooks()
    {
        $faker = Factory::create();

        $dbc = \Y::db()->createCommand();

        for ($i = 0; $i < 2500; $i++) {
            $data = [];
            for ($j = 0; $j < 10000; $j++) {
                $title = $faker->sentence();
                $data[] = [$title, \Y::generateSlug($title)];
            }
            $dbc->batchInsert('book', ['title', 'slug'], $data)->execute();
            \L::success("Finished butch {$i}");
        }
    }

    public function actionAuthorsToBooks()
    {
        $minAuthorId = intval(Author::find()->min('id'));
        $maxAuthorId = intval(Author::find()->max('id'));

        $query = Book::find()->andWhere(['authors_count' => 0])->select("id")->asArray();

        $dbc = \Y::db()->createCommand();

        foreach ($query->batch(1000) as $idx => $books) {
            $data = [];
            foreach ($books as $book) {
                $authorsCount = rand(1, 4);
                for ($i = 0; $i < $authorsCount; $i++) {
                    do {
                        $authorId = rand($minAuthorId, $maxAuthorId);
                    } while (!Author::find()->andWhere(['id' => $authorId])->exists());
                    $data[] = [$authorId, intval($book["id"])];
                }
                $dbc->update("book", ['authors_count' => $authorsCount], ['id' => intval($book["id"])])
                    ->execute();
            }
            $dbc->batchInsert('author_books', ['author_id', 'book_id'], $data)->execute();
            \L::success("Finished butch {$idx}");
        }

    }

    public function actionUsersToBooks()
    {
        $minAuthorId = intval(User::find()->min('id'));
        $maxAuthorId = intval(User::find()->max('id'));

        $query = Book::find()->andWhere(['users_count' => 0])->select("id")->asArray();

        $dbc = \Y::db()->createCommand();

        foreach ($query->batch(1000) as $idx => $books) {
            $data = [];
            foreach ($books as $book) {
                $usersCount = rand(1, 4);
                for ($i = 0; $i < $usersCount; $i++) {
                    do {
                        $userId = rand($minAuthorId, $maxAuthorId);
                    } while (!Author::find()->andWhere(['id' => $userId])->exists());
                    $data[] = [$userId, intval($book["id"])];
                }
                $dbc->update("book", ['users_count' => $usersCount], ['id' => intval($book["id"])])
                    ->execute();
            }
            $dbc->batchInsert('user_books', ['user_id', 'book_id'], $data)->execute();
            \L::success("Finished butch {$idx}");
        }

    }
}