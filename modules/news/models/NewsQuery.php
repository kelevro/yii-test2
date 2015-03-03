<?php

namespace news\models;

class NewsQuery extends \common\base\ActiveQuery
{
    /**
     * @return static
     */
    public function notSended()
    {
        return $this->andWhere(['is_sended' => 0]);
    }
}
