<?php

namespace backend\models;

use common\base\ActiveDataProvider;
use yii\base\Model;
use Yii;
use yii\db\ActiveQuery;

/**
 * Search model for alerts
 *
 * @package backend\models
 */
class AlertSearch extends Model
{
    protected $projectId;

    /**
     * @param int $projectId
     * @param array $config
     */
    public function __construct($projectId, $config = [])
    {
        $this->projectId = $projectId;

        parent::__construct($config);
    }

    /**
     * @return ActiveDataProvider
     */
    public function search()
    {
        /** @var ActiveQuery $query */
        $query = Alert::find()
            ->project($this->projectId)
            ->orderBy('date_created DESC');

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
    }

}