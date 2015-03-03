<?php

namespace product\models;

use common\helpers\Storage;
use Yii;
use \common\base\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $price_id
 * @property string $category_id
 * @property int $wholesale
 * @property int $small_wholesale
 * @property int $count
 * @property string $slug
 * @property string $producer
 * @property string $title
 * @property string $description
 * @property integer $is_enabled
 * @property integer $is_deleted
 * @property integer $price
 * @property integer $position
 * @property string $date_created
 *
 * @property Attribute[] $productAttributes
 * @property Image[] $images
 * @property Category $category
 * @property Documentation[] $documentations
 * @property AttributeValue[] $attrs
 * @property Product[] $relatedProducts
 */
class Product extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'slug'], 'required'],
            [['category_id', 'price_id'], 'integer'],
            [['description'], 'string'],
            [['wholesale', 'small_wholesale', 'price'], 'number'],
            [['date_created', 'producer', 'count'], 'safe'],
            [['is_enabled'], 'boolean'],
            [['title', 'slug'], 'string', 'max' => 100]
        ];
    }

    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            'seoData' => [
                'class' => '\seo\behaviors\SeoData',
                'ruleParams' => function() {
                        return ['product/default/product', ['product' => $this->id]];
                    },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'price_id'              => 'Price ID',
            'category_id'           => 'Category',
            'title'                 => 'Title',
            'description'           => 'Description',
            'price'                 => 'Price',
            'date_created'          => 'Date Created',
            'documentation_id'      => 'Documentation',
        ];
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributes()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])
            ->viaTable('attribute_to_product', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return null|Image
     */
    public function getMainPhoto()
    {
        if (empty($this->images[0])) {
            return null;
        }

        return $this->images[0];
    }

    public function getAttrs()
    {
        return $this->hasMany(AttributeValue::className(), ['product_id' => 'id']);
    }

    /**
     * @return Documentation[]|null
     */
    public function findRelatedDocumentations()
    {
        $query = Documentation::find()
            ->innerJoin(
                'product_to_documentation ptd',
                sprintf('documentation_id = %s.id', Documentation::tableName()))
            ->innerJoin(
                Product::tableName(),
                sprintf('%s.id = ptd.product_id AND ptd.product_id = %d', Product::tableName(), $this->id))
            ->orderBy('ptd.id');

        return $query->all();
    }

    /**
     * @return static
     */
    public function getDocumentations()
    {
        return $this->hasMany(Documentation::className(), ['id' => 'documentation_id'])
            ->viaTable('product_to_documentation', ['product_id' => 'id']);
    }

    public function getRelatedProducts()
    {
        return $this->hasMany(static::className(), ['id' => 'child_id'])
            ->viaTable('product_to_product', ['parent_id' => 'id']);
    }
}
