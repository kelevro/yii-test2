<?php

namespace product\models;

use Yii;
use \common\base\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $order_profile_id
 * @property integer $is_closed
 * @property integer $is_deleted
 * @property string $description
 * @property string $date_created
 *
 * @property OrderValue[] $values
 * @property OrderProfile $profile
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_closed', 'is_deleted'], 'boolean'],
            [['date_created', 'description'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_closed' => 'Is Closed',
            'is_deleted' => 'Is Deleted',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(OrderValue::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(OrderProfile::className(), ['id' => 'order_profile_id']);
    }

    public function getSummaryCost()
    {
        $cost = 0;
        /** @var OrderValue[] $values */
        $values = $this->getValues()->with('product')->all();
        foreach ($values as $value) {
            $cost += ($value->product->price * $value->count);
        }
        return $cost;
    }
}
