<?php

use backend\components\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var mail\models\SubscriberSearch $searchModel
 */
?>

<div class="table-wrapper subscriber list">
    <div class="row filter-block">
        <h4 class="pull-left">Subscribers</h4>

        <div class="pull-left col-md-offset-1">
            <?= Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'label' => 'Subscribe',
                    'attribute' => 'is_enabled',
                    'filter' => [0 => 'No', 1 => 'Yes'],
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function($row) {
                            if ($row->is_enabled) {
                                return '<span class="label label-success">Subscribe</span>';
                            } else {
                                return '<span class="label label-info">Not subscribe</span>';
                            }
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'label' => 'Email',
                    'attribute' => 'email',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'value' => function($row) {
                            return Html::a($row->email, ['update', 'id' => $row->id]);
                        },
                    'format' => 'raw',
                ],
                'date_created',
                [
                    'class'=>'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'text-align: center'],
                    'headerOptions' => ['class' => 'col-md-1'],
                    'template'=>'{enabled} {delete}',
                    'buttons' => [
                        'enabled' => function ($url, $model) {
                                $button = '<i class="fa fa-power-off" style="font-size: 23px"></i>';
                                $title  = 'Subscribe';
                                if ($model->is_enabled) {
                                    $button     = '<i class="fa fa-minus-circle" style="font-size: 23px"></i>';
                                    $url        = Url::toRoute(['/mail/subscriber/disabled', 'id' => $model->id]);
                                    $title      = 'Unsubscribe';
                                }
                                /** @var ActionColumn $column */
                                return Html::a($button, $url, [
                                    'title'         => $title,
                                    'data-method'   => 'post',
                                ]);
                            },
                        'delete' => function ($url, $model) {
                                /** @var ActionColumn $column */
                                return Html::a('<span class="glyphicon glyphicon-trash" style="font-size: 19px; padding-left: 10px"></span>', $url, [
                                    'title' => 'Delete',
                                    'data-confirm' => 'Are you sure to delete this item?',
                                    'data-method' => 'post',
                                ]);
                            },
                    ],
                ]
            ],
        ]); ?>
    </div>
</div>