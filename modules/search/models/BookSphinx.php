<?php  namespace search\models; 

use yii\sphinx\ActiveQuery;
use yii\sphinx\ActiveRecord;

class BookSphinx extends ActiveRecord
{
    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return (new ActiveQuery(get_called_class()))->asArray();
    }

    public static function indexName()
    {
        return 'idx_book';
    }
}