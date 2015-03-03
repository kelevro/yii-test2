<?php

namespace product\models;

use Yii;

/**
 * This is the model class for table "order_profile".
 *
 * @property string $id
 * @property string $username
 * @property string $phone
 * @property string $email
 *
 * @property Order[] $orders
 */
class OrderProfile extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'phone', 'email'], 'required'],
            [['username', 'phone', 'email'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'phone' => 'Phone',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['order_profile_id' => 'id']);
    }
}
