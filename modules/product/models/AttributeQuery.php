<?php
namespace product\models;

use common\base\ActiveQuery;

class AttributeQuery extends ActiveQuery
{
    public function category($categoryId)
    {
        return $this->andWhere(['category_id' => $categoryId]);
    }
}