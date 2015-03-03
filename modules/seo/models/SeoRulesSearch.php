<?php


namespace seo\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * Search model for seo rules
 *
 * @package seo\models
 */
class SeoRulesSearch extends Model
{
    protected $projectId;

    public $id;
    public $route;

    /**
     * @inheritdoc
     */
    public function __construct($projectId, $config = [])
    {
        parent::__construct($config);

        $this->projectId = $projectId;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'route'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'route' => 'Route',
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SeoRule::find();
        $query->andWhere(['project_id' => $this->projectId]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'route');

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

    /**
     * @return []
     */
    public function getRoutesList()
    {
        return \Yii::$app->getModule('seo')->getRoutesWithTitles();
    }


    /**
     * @return []
     */
    public function getModelsList()
    {
        return \Yii::$app->getModule('seo')->getModelsWithTitles();
    }
}