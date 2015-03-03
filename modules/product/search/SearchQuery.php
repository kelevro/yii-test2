<?php

namespace product\search;

use Yii;

/**
 * This is the model class for table "search_query".
 *
 * @property string $id
 * @property string $hash
 * @property string $data
 */
class SearchQuery extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search_query';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hash', 'data'], 'required'],
            [['data'], 'string'],
            [['hash'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'data' => 'Data',
        ];
    }
}
