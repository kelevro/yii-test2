<?
/**
 * @var \yii\web\View $this
 * @var \common\base\ActiveDataProvider $dataProvider
 * @var \backend\models\AlertSearch $searchModel
 */
use backend\models\Alert;
use yii\grid\GridView;

?>

<div class="table-wrapper partner list">
    <div class="row filter-block">
        <h4 class="pull-left">Alerts</h4>
    </div>
    <div class="row">
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'      => [
                [
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value'         => function ($row) {
                            /** @var Alert $row */
                            return '<i class="fa '
                            . ($row->type == Alert::TYPE_WARNING ? 'fa-exclamation-triangle' : 'fa-info-circle')
                            . '"></i> &nbsp; '
                            . \Y::format()->asTime($row->date_created);
                        },
                    'format'        => 'raw',
                ],
                [
                    'headerOptions' => ['class' => 'col-md-1'],
                    'attribute'     => 'from',
                ],
                [
                    'attribute' => 'message',
                ],
            ],
        ]);?>
    </div>
</div>