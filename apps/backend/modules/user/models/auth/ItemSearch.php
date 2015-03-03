<?php

namespace user\models\auth;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use user\models\auth\Item;

/**
 * ItemSearch represents the model behind the search form about Item.
 */
class ItemSearch extends Model
{
    // protected $projectId;

    public $name;
    public $type;
    public $description;
    public $biz_rule;
    public $data;

    /*
    public function __construct($projectId, $config = [])
    {
        parent::__construct($config);

        $this->projectId = $projectId;
    }
    */

    public function rules()
    {
        return [
            [['name', 'description', 'biz_rule', 'data'], 'safe'],
            [['type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'biz_rule' => 'Biz Rule',
            'data' => 'Data',
        ];
    }

    public function search($params)
    {
        $query = Item::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'name', true);
        $this->addCondition($query, 'type');
        $this->addCondition($query, 'description', true);
        $this->addCondition($query, 'biz_rule', true);
        $this->addCondition($query, 'data', true);
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
