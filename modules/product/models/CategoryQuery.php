<?php
namespace product\models;

use common\base\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    /**
     * Add min level category criteria
     *
     * @param int $lvl
     * @return self
     */
    public function minLvl($lvl)
    {
        return $this->andWhere('lvl >= :l', [':l' => $lvl]);
    }

    /**
     * Add max level category criteria
     *
     * @param int $lvl
     * @return self
     */
    public function maxLvl($lvl)
    {
        return $this->andWhere('lvl <= :l', [':l' => $lvl]);
    }

}