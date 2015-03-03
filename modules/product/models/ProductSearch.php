<?php

namespace product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use product\models\Product;

/**
 * ProductSearch represents the model behind the search form about Product.
 */
class ProductSearch extends Model
{
    // protected $projectId;

    public $id;
    public $category_id;
    public $title;
    public $description;
    public $is_enabled;
    public $date_created;
    public $has_docs;
    public $price_id;


    public function rules()
    {
        return [
            [['id', 'category_id', 'price_id'], 'integer'],
            [['is_enabled', 'has_docs'], 'boolean'],
            [['title', 'description', 'date_created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'category_id'   => 'Category',
            'title'         => 'Title',
            'description'   => 'Description',
            'is_enabled'    => 'Enabled',
            'date_created'  => 'Date Created',
            'has_docs'      => 'Documentation',
        ];
    }

    public function search($params, $deleted = false)
    {
        $query = Product::find();

        if ($deleted) {
            $query->deleted();
        } else {
            $query->active();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'category_id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'description', true);
        $this->addCondition($query, 'price_id', true);
        $this->addCondition($query, 'is_enabled');
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
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
