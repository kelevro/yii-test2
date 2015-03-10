<?php  namespace search\models; 

use content\models\Book;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class BookSearch extends Model
{
    public $term;

    public function rules()
    {
        return [
            ['term', 'filter', 'filter' => 'trim'],
            ['term', 'string'],
        ];
    }

    public function search($params)
    {
        if (!($this->load($params, '') && $this->validate())) {
            return [];
        }
        $books = BookSphinx::find()
            ->select("id")
            ->match($this->term)
            ->asArray()
            ->all();

        $ids = ArrayHelper::getColumn($books, 'id');

        return Book::findAll(['id' => $ids]);
    }
}