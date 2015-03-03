<?php

namespace user\models\auth;

/**
 * RBAC model
 *
 * @property string $item_name
 * @property string $user_id
 * @property string $biz_rule
 * @property string $data
 */
class Assignment extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['biz_rule', 'data'], 'string'],
            [['item_name', 'user_id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'biz_rule' => 'Biz Rule',
            'data' => 'Data',
        ];
    }
}
