<?php

namespace product\models;

use Yii;

/**
 * This is the model class for table "order_to_product".
 *
 * @property string $id
 * @property string $product_id
 * @property string $order_id
 * @property integer $count
 *
 * @property Order $order
 * @property Product $product
 */
class OrderValue extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_to_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'order_id'], 'required'],
            [['product_id', 'order_id', 'count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'order_id' => 'Order ID',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function getSummPrice()
    {
        return $this->count * $this->product->price;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
