<?php

namespace product\models;

use common\helpers\Storage;
use Yii;
use \common\base\ActiveRecord;
use common\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $slug
 * @property string $title
 * @property boolean $is_enabled
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $img
 * @property string $img_title
 * @property string $img_alt
 * @property string $date_created
 *
 * @property Attribute[] $categoryAttributes
 * @property Product[] $products
 */
class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @return \common\base\ActiveQuery|CategoryQuery|\yii\db\ActiveQuery|\yii\db\ActiveQueryInterface
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        if ($this->isNewRecord) {
            $this->is_enabled = 1;
        }
    }

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => 'creocoder\yii\behaviors\NestedSet',
                'levelAttribute' => 'lvl',
            ],
            'seoData' => [
                'class' => '\seo\behaviors\SeoData',
                'ruleParams' => function() {
                        return ['product/default/category', ['category' => $this->id]];
                    },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'required'],
            [['lft', 'rgt', 'lvl'], 'integer'],
            [['is_enabled'], 'boolean'],
            [['date_created'], 'safe'],
            [['title', 'slug', 'img', 'img_title', 'img_alt'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryAttributes()
    {
        return $this->hasMany(Attribute::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        return true;
    }

    public static function getRecordsList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @param string $size
     * @return string
     */
    public function getMainPhotoUrlBySize($size = 'big')
    {
        if (empty($this->img)) {
            return false;
        }

        return Storage::getStorageUrlTo("/product/category/{$size}/{$this->img}");
    }

    /**
     * @param bool $three
     * @return Attribute[] | null
     */
    public function getAttrs($three = true)
    {
        $category = Category::findOne($this->id)->ancestors()->select('id')->column();

        return Attribute::find()->category(array_merge($category, [$this->id]))->all();
    }

    public function getAttrsList($three = true)
    {
        $category = Category::findOne($this->id)->ancestors()->select('id')->column();
        /** @var Attribute[] $attributes */
        $attributes = ArrayHelper::map(
            Attribute::find()->category(array_merge($category, [$this->id]))->all(),
            'id', 'title'
        );
        return $attributes;
    }
}
