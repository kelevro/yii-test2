<?php

namespace user\models;

class UserQuery extends \common\base\ActiveQuery
{
    /**
     * Scope - only active users
     *
     * @return self
     */
    public function active()
    {
        return $this->andWhere(['is_deleted' => 0]);
    }

    /**
     * Adds user role conditions
     *
     * @param string $role
     * @return \yii\db\Query
     */
    public function role($role)
    {
        $t = $this->table();
        return $this->innerJoin('auth_assignment AS aa',
            "aa.user_id = {$t}.id AND item_name = :role", [':role' => $role]);
    }
}