<?php

namespace product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use product\models\DocumentationCategory;

/**
 * DocumentationCategorySearch represents the model behind the search form about DocumentationCategory.
 */
class DocumentationCategorySearch extends Model
{
    // protected $projectId;

	public $id;
	public $title;
	public $slug;
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
			[['id'], 'integer'],
			[['title', 'slug', 'date_created'], 'safe'],
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
			'slug' => 'Slug',
			'date_created' => 'Date Created',
		];
	}

	public function search($params)
	{
		$query = DocumentationCategory::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'title', true);
		$this->addCondition($query, 'slug', true);
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
