<?php

namespace slider\models;

use \common\base\ActiveQuery;

class SliderQuery extends ActiveQuery
{

    /**
     * Scope - sort by weight
     *
     * @return self
     */
    public function sortByWeight()
    {
        return $this->addOrderBy($this->table().'.weight');
    }
}