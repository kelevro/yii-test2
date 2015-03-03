<?php
namespace product\models;

use common\base\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    /**
     * @param int|array $categories
     * @return static
     */
    public function categories($categories)
    {
        return $this->andWhere(['category_id' => $categories]);
    }

    public function orderByPosition()
    {
        return $this->addOrderBy('position');
    }

    public function titleLike($like)
    {
        return $this->andWhere("title like :like", [':like' => "%{$like}%"]);
    }
}