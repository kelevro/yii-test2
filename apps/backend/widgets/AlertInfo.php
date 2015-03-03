<?php


namespace backend\widgets;

use backend\models\Alert;
use yii\bootstrap\Widget;

/**
 * Widget with system alerts
 *
 * @package backend\widgets
 */
class AlertInfo extends Widget
{
    public $limit = 5;

    public function run()
    {
        $count = Alert::find()
            ->where('date_created >= :d', [':d' => date('Y-m-d 00:00:00')])
            ->project(\Y::projectId())
            ->count();

        $last = Alert::find()
            ->where('date_created >= :d', [':d' => date('Y-m-d 00:00:00')])
            ->project(\Y::projectId())
            ->limit($this->limit)
            ->all();


        return $this->render('alert-info', [
            'count' => $count,
            'last'  => $last,
        ]);
    }
}