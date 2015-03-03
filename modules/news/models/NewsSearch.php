<?php

namespace news\models;

use yii\base\Model;use yii\data\ActiveDataProvider;use news\models\News;

/*** NewsSearch represents the model behind the search form about News.*/class NewsSearch extends Model{// protected $projectId;

public $id;
	public $title;
	public $content;
	public $is_enabled;
	public $preview_img;
	public $date_created;
	public $date_updated;

/*public function __construct($config = []){parent::__construct($config);
}*/

public function rules()    {        return [
[['id'], 'integer'],
			[['title', 'content', 'preview_img', 'date_created', 'date_updated'], 'safe'],
			[['is_enabled'], 'boolean'],        ];    }

/**    * @inheritdoc    */    public function attributeLabels()    {        return [
    'id' => 'ID',
    'title' => 'Title',
    'content' => 'Content',
    'is_enabled' => 'Is Enabled',
    'preview_img' => 'Preview Img',
    'date_created' => 'Date Created',
    'date_updated' => 'Date Updated',
];    }

public function search($params)    {        $query = News::find();        $dataProvider = new ActiveDataProvider([            'query' => $query,        ]);

if (!($this->load($params) && $this->validate())) {            return $dataProvider;        }

$this->addCondition($query, 'id');
		$this->addCondition($query, 'title', true);
		$this->addCondition($query, 'content', true);
		$this->addCondition($query, 'is_enabled');
		$this->addCondition($query, 'preview_img', true);
		$this->addCondition($query, 'date_created');
		$this->addCondition($query, 'date_updated');
return $dataProvider;    }

protected function addCondition($query, $attribute, $partialMatch = false)    {        $value = $this->$attribute;        if (trim($value) === '') {            return;        }        if ($partialMatch) {            $value = '%' . strtr($value, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%';            $query->andWhere(['like', $attribute, $value]);        } else {            $query->andWhere([$attribute => $value]);        }    }}
