<?php

namespace user\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use user\models\User;

/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends Model
{
    protected $projectId;

	public $id;
	public $email;
	public $password_hash;
	public $auth_key;
	public $is_deleted;
	public $date_created;
	public $date_updated;
	public $date_last_login;
	public $date_deleted;

    /**
     * @param int $projectId
     * @param array $config
     */
    public function __construct($projectId, $config = [])
    {
        parent::__construct($config);

        $this->projectId = $projectId;
    }


	public function rules()
	{
		return [
			[['id', 'project_id'], 'integer'],
			[['email', 'password_hash', 'auth_key', 'date_created', 'date_updated', 'date_last_login', 'date_deleted'], 'safe'],
			[['is_deleted'], 'boolean'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'project_id' => 'Project ID',
			'email' => 'Email',
			'password_hash' => 'Password Hash',
			'auth_key' => 'Auth Key',
			'is_deleted' => 'Is Deleted',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'date_last_login' => 'Date Last Login',
			'date_deleted' => 'Date Deleted',
		];
	}

	public function search($params, $role = null)
	{
		$query = User::find();
        $query->where('project_id = :pid OR project_id IS NULL', [':pid' => $this->projectId]);
        if ($role) {
            $query->role($role);
        }
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'project_id');
		$this->addCondition($query, 'email', true);
		$this->addCondition($query, 'password_hash', true);
		$this->addCondition($query, 'auth_key', true);
		$this->addCondition($query, 'is_deleted');
		$this->addCondition($query, 'date_created');
		$this->addCondition($query, 'date_updated');
		$this->addCondition($query, 'date_last_login');
		$this->addCondition($query, 'date_deleted');
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
