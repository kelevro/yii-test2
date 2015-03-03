<?php

namespace product\models;

use Yii;
use \common\base\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "attribute".
 *
 * @property string $id
 * @property string $category_id
 * @property string $title
 * @property boolean $is_selectable
 * @property string $data
 * @property string $filters
 * @property string $date_created
 *
 * @property array $values
 *
 * @property Category $category
 */
class Attribute extends ActiveRecord
{
    /**
     * @var array
     */
    public $values = [];

    /**
     * @var array
     */
    public $filterValues = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title'], 'required'],
            [['category_id'], 'integer'],
            [['is_selectable'], 'boolean'],
            [['date_created', 'data', 'filters'], 'safe'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    public function afterFind()
    {
        if ($this->data) {
            $this->values = Json::decode($this->data);
        }

        if ($this->filters) {
            $this->filterValues = Json::decode($this->filters);
        }

        return true;
    }

    /**
     * @return \common\base\ActiveQuery|AttributeQuery|\yii\db\ActiveQuery|\yii\db\ActiveQueryInterface
     */
    public static function find()
    {
        return new AttributeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'category_id'   => 'Category',
            'title'         => 'Title',
            'date_created'  => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
