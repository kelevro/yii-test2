<?php

namespace content\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BookSearch represents the model behind the search form about Book.
 */
class BookSearch extends Model
{

    public $id;
    public $title;
    public $date_created;
    public $date_updated;


    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'date_created', 'date_updated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    public function search($params)
    {
        $query = Book::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'title', true);
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
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
