<?php

namespace statical\models;

/**
 * This is the model class for table "text".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $content
 * @property integer $is_available
 * @property string $date_created
 * @property string $date_updated
 */
class Text extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'content'], 'required'],
            [['content'], 'string'],
            [['is_available'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['alias'], 'string', 'max' => 45],
            [['alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'alias'         => 'Alias',
            'content'       => 'Content',
            'is_available'  => 'Is Available',
            'date_created'  => 'Date Created',
            'date_updated'  => 'Date Updated',
        ];
    }

    /**
     * @param string $alias
     * @return null|self
     */
    public static function findByAlias($alias)
    {
        return self::find(['alias' => $alias]);
    }

    public static function getPlainTextByAlias($alias)
    {
        $text = self::find()->select('content')->where(['alias' => $alias])->scalar();
        if (empty($text)) {
            return '';
        }

        return $text;
    }
}
