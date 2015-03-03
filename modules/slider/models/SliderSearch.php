<?php

namespace slider\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use slider\models\Slider;

/*** SliderSearch represents the model behind the search form about Slider.*/
class SliderSearch extends Model
{ // protected $projectId;

    public $id;
    public $image;
    public $weight;
    public $alt;
    public $title;
    public $url;
    public $date_created;
    public $date_updated;

    /*public function __construct($config = []){parent::__construct($config);
    }*/

    public function rules()
    {
        return [
            [['id', 'weight'], 'integer'],
            [['image', 'alt', 'title', 'url', 'date_created', 'date_updated'], 'safe'],];
    }

    /**    * @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'weight' => 'Weight',
            'alt' => 'Alt',
            'title' => 'Title',
            'url' => 'Url',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    public function search($params)
    {
        $query = Slider::find();
        $dataProvider = new ActiveDataProvider(['query' => $query,]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'image', true);
        $this->addCondition($query, 'weight');
        $this->addCondition($query, 'alt', true);
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'url', true);
        $this->addCondition($query, 'date_created');
        $this->addCondition($query, 'date_updated', true);
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
