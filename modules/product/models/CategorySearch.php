<?php

namespace product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use product\models\Category;

/**
 * CategorySearch represents the model behind the search form about Category.
 */
class CategorySearch extends Model
{
    // protected $projectId;

	public $id;
	public $title;
	public $weight;
	public $date_created;

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
			[['id', 'weight'], 'integer'],
			[['title', 'date_created'], 'safe'],
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
			'weight' => 'Weight',
			'date_created' => 'Date Created',
		];
	}

	public function search($params)
	{
		$query = Category::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'title', true);
		$this->addCondition($query, 'weight');
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
			$value = '%' . strtr($value, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%';
			$query->andWhere(['like', $attribute, $value]);
		} else {
			$query->andWhere([$attribute => $value]);
		}
	}
}
