<?php  namespace content\models; 

use common\base\ActiveQuery;
use common\helpers\ArrayHelper;
use yii\base\Exception;

class BookQuery extends ActiveQuery
{
    public function reading()
    {
        return $this->andWhere(['>', 'users_count', 0]);
    }

    public function hasAuthorsCount($count)
    {
        return $this->andWhere(['>=', 'authors_count', $count]);
    }

    public function hasUsersCount($count)
    {
        return $this->andWhere(['>=', 'users_count', $count]);
    }

    public function random($limit = 5)
    {
        $minBookId = intval(Book::find()->min('id'));
        $maxBookId = intval(Book::find()->max('id'));

        if (!$limit) {
            throw new Exception('Limit is required');
        }

        $ids = ArrayHelper::generateRandomKeys($minBookId, $maxBookId, $limit * 2);

        return $this->andWhere(['id' => $ids])->limit($limit);
    }
}