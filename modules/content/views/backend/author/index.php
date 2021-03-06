<?php

use backend\components\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var content\models\AuthorSeatch $searchModel
 */
?>

<div class="table-wrapper author list">
    <div class="row filter-block">
        <h4 class="pull-left">Authors</h4>

        <div class="pull-left col-md-offset-1">
            <?= Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'name',
                    'value' => function($row) {
                        return Html::a($row->name, ['/content/author/update', 'id' => $row->id]);
                    },
                    'format' => 'raw',
                ],
                'date_created',
                'date_updated',
                [
                    'class'=>'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'text-align: center'],
                    'template'=>'{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            /** @var \yii\grid\ActionColumn $column */
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