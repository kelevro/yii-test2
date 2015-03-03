<?php
namespace product\models;

use common\base\ActiveQuery;

class AttributeValueQuery extends ActiveQuery
{
    public function product($productId)
    {
        return $this->andWhere(['product_id' => $productId]);
    }

    public function attr($attribute)
    {
        return $this->andWhere(['attribute_id' => $attribute]);
    }
}