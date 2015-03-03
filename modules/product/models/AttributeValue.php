<?php

namespace product\models;

use Yii;
use \common\base\ActiveRecord;

/**
 * This is the model class for table "attribute_to_product".
 *
 * @property string $id
 * @property string $attribute_id
 * @property string $product_id
 * @property string $value
 * @property string $filter
 *
 * @property Product $product
 * @property Attribute $attribute
 */
class AttributeValue extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_to_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'product_id'], 'required'],
            [['attribute_id', 'product_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['filter'], 'string', 'max' => 45]
        ];
    }

    public static function find()
    {
        return new AttributeValueQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'attribute_id'  => 'Attribute ID',
            'product_id'    => 'Product ID',
            'value'         => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function addValue($productId, $attributeId, $value, $filter = null)
    {
        if ($attrValue = self::find()->product($productId)->attr($attributeId)->one()) {
            $attrValue->value   = $value;
            $attrValue->filter  = $filter;
            $attrValue->save(false, ['value', 'filter']);
            return true;
        }
        $attrValue                  = new self;
        $attrValue->product_id      = $productId;
        $attrValue->attribute_id    = $attributeId;
        $attrValue->value           = $value;
        $attrValue->filter          = $filter;
        $attrValue->save(false);
        return true;
    }
}
