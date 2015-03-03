<?php

namespace mail\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use mail\models\Subscriber;

/**
 * SubscriberSearch represents the model behind the search form about Subscriber.
 */
class SubscriberSearch extends Model
{
    // protected $projectId;

	public $id;
	public $email;
	public $is_enabled;
	public $date_created;
	public $date_updated;
	public $date_last_sent;
	public $date_opened;

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
			[['id', 'is_enabled'], 'integer'],
			[['email', 'date_created', 'date_updated', 'date_last_sent', 'date_opened'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'email' => 'Email',
			'is_enabled' => 'Is Enabled',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'date_last_sent' => 'Date Last Sent',
			'date_opened' => 'Date Opened',
		];
	}

	public function search($params)
	{
		$query = Subscriber::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'email', true);
		$this->addCondition($query, 'is_enabled');
		$this->addCondition($query, 'date_created');
		$this->addCondition($query, 'date_updated');
		$this->addCondition($query, 'date_last_sent');
		$this->addCondition($query, 'date_opened');
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
