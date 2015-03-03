<?php

namespace product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use product\models\Attribute;

/**
 * AttributeSearch represents the model behind the search form about Attribute.
 */
class AttributeSearch extends Model
{
    // protected $projectId;

	public $id;
	public $category_id;
	public $title;
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
			[['id', 'category_id'], 'integer'],
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
			'category_id' => 'Category ID',
			'title' => 'Title',
			'date_created' => 'Date Created',
		];
	}

	public function search($params)
	{
		$query = Attribute::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'category_id');
		$this->addCondition($query, 'title', true);
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
