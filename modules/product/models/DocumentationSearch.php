<?php

namespace product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use product\models\Documentation;

/**
 * DocumentationSearch represents the model behind the search form about Documentation.
 */
class DocumentationSearch extends Model
{
    // protected $projectId;

    public $id;
    public $link;
    public $title;
    public $category_id;
    public $date_created;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['link', 'title', 'date_created', 'category_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'title' => 'Title',
            'date_created' => 'Date Created',
        ];
    }

    public function search($params)
    {
        $query = Documentation::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'link', true);
        $this->addCondition($query, 'category_id');
        $this->addCondition($query, 'title', true);
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
