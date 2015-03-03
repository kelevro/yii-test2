<?php

namespace statical\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use statical\models\Text;

/**
 * TextSearch represents the model behind the search form about Text.
 */
class TextSearch extends Model
{

    public $id;
    public $title;
    public $alias;
    public $content;
    public $is_available;
    public $date_created;
    public $date_updated;

    public function rules()
    {
        return [
            [['id', 'is_available'], 'integer'],
            [['title', 'alias', 'content', 'date_created', 'date_updated'], 'safe'],];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'alias'         => 'Alias',
            'content'       => 'Content',
            'is_available'  => 'Is Available',
            'date_created'  => 'Date Created',
            'date_updated'  => 'Date Updated',
        ];
    }

    public function search($params)
    {
        $query = Text::find();
        $dataProvider = new ActiveDataProvider(['query' => $query,]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'alias', true);
        $this->addCondition($query, 'content', true);
        $this->addCondition($query, 'is_available');
        $this->addCondition($query, 'date_created');
        $this->addCondition($query, 'date_updated');
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
