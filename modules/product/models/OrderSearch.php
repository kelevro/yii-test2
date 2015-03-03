<?php

namespace product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use product\models\Order;

/**
 * OrderSearch represents the model behind the search form about Order.
 */
class OrderSearch extends Model
{
    // protected $projectId;

    public $id;
    public $is_closed;
    public $is_deleted;
    public $date_created;

    public function rules()
    {
        return [
            [['id', 'is_closed', 'is_deleted'], 'integer'],
            [['date_created'], 'safe'],
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

    public function search($params)
    {
        $query = Order::find()->active();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'is_closed');
        $this->addCondition($query, 'is_deleted');
        $this->addCondition($query, 'date_created');
        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $value = '%' . strtr($value, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%';
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
