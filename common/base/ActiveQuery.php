<?php

namespace common\base;

class ActiveQuery extends \yii\db\ActiveQuery
{

    /**
     * @return string model table name
     */
    protected function table()
    {
        return call_user_func([$this->modelClass, 'tableName']);
    }


    /**
     * Scope - only available products
     *
     * @return self
     */
    public function published()
    {
        return $this->andWhere([$this->table() . '.is_available' => 1]);
    }


    /**
     * Select only active users
     *
     * @return self
     */
    public function active()
    {
        return $this->andWhere(['is_deleted' => 0]);
    }

    /**
     * Select only active users
     *
     * @return self
     */
    public function deleted()
    {
        return $this->andWhere(['is_deleted' => 1]);
    }

    /**
     * Only enabled records
     */
    public function enabled()
    {
        return $this->andWhere([$this->table().'.is_enabled' => 1]);
    }

    /**
     * Only enabled records
     */
    public function disabled()
    {
        return $this->andWhere([$this->table().'.is_enabled' => 0]);
    }

    /**
     * Adds order by date_updated and date_created
     *
     * @return static
     */
    public function orderByDatesDesc()
    {
        $t = $this->table();
        return $this->addOrderBy("{$t}.date_updated DESC, {$t}.date_created DESC");
    }

    /**
     * Adds slug condition
     *
     * @param string $slug
     * @return static
     */
    public function slug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }
}