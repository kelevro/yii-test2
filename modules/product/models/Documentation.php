<?php

namespace product\models;

use Yii;

/**
 * This is the model class for table "documentation".
 *
 * @property string $id
 * @property string $category_id
 * @property string $link
 * @property string $title
 * @property string $date_created
 *
 * @property Product[] $products
 * @property DocumentationCategory[] $category
 */
class Documentation extends \common\base\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documentation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
            [['date_created', 'category_id'], 'safe'],
            [['link', 'title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'title' => 'Title',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['documentation_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(DocumentationCategory::className(), ['id' => 'category_id']);
    }

}
