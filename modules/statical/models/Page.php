<?php

namespace statical\models;

use menu\models\MainMenu;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property boolean $is_available
 * @property string $view_file
 * @property string $css_file
 * @property string $date_created
 * @property string $date_updated
 *
 */
class Page extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'content'], 'required'],
            [['content'], 'string'],
            [['is_available'], 'boolean'],
            [['date_created', 'date_updated'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['slug', 'view_file', 'css_file'], 'string', 'max' => 45]
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
            'slug'          => 'Slug',
            'content'       => 'Content',
            'is_available'  => 'Is Available',
            'view_file'     => 'View File',
            'css_file'      => 'Css File',
            'date_created'  => 'Date Created',
            'date_updated'  => 'Date Updated',
        ];
    }

    /**
     * @param string $alias
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByAlias($alias)
    {
        return self::find()->published()->andWhere(['alias' => $alias])->one();
    }
}
