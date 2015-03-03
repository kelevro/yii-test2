<?php

use backend\components\Html;
use yii\grid\GridView;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var product\models\OrderSearch $searchModel
 */
?>

<div class="table-wrapper order list">
    <div class="row filter-block">
        <h4 class="pull-left">Orders</h4>
        <div class="pull-left col-md-offset-1">
            <?=Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'username',
                    'value' => function($row) {
                            return Html::a($row->profile->username, ['view', 'id' => $row->id]) ;
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'email',
                    'value' => function($row) {
                            return $row->profile->email;
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'phone',
                    'value' => function($row) {
                            return $row->profile->phone;
                        },
                    'format' => 'raw',
                ],
                [
                    'label'         => 'Summary cost',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function($row) {
                            return $row->getSummaryCost();
                        },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Closed',
                    'attribute' => 'is_closed',
                    'filter' => [0 => 'No', 1 => 'Yes'],
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function($row) {
                            if ($row->is_closed) {
                                return '<span class="label label-info">Closed</span>';
                            } else {
                                return '<span class="label label-success">Opened</span>';
                            }
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'date_created',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'format' => 'datetime'
                ],
                [
                    'class'=>'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'text-align: center'],
                    'template'=>'{delete}',
                    'buttons' => [
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