<?php

use backend\components\Html;
use yii\grid\GridView;
use product\models\Product;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var product\models\ProductSearch $searchModel
 */
?>

<div class="table-wrapper product list">
    <div class="row filter-block">
        <h4 class="pull-left">Products Deleted</h4>
    </div>

    <div class="row">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'label' => 'image',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($row) {
                            /** @var Product $row */
                            $src = ($image = $row->getMainPhoto())
                                ? $image->getUrlBySize('xsmall')
                                : 'http://placehold.it/80x80';
                            return Html::img($src);
                        },
                    'format' => 'raw',
                    'filter' => false,
                ],
                [
                    'attribute' => 'is_enabled',
                    'filter' => [0 => 'No', 1 => 'Yes'],
                    'value' => function ($row) {
                            return ($row->is_enabled)?'Yes':'No';
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'title',
                    'value' => function($row) {
                            /** @var \product\models\Product $row */
                            return Html::a($row->title, ['update', 'id' => $row->id]);
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'category_id',
                    'filter'    => \product\models\Category::getRecordsList(),
                    'value' => function($row) {
                            /** @var \product\models\Product $row */
                            return Html::a($row->category->title, ['/product/category/update', 'id' => $row->category_id]);
                        },
                    'format' => 'raw',
                ],
                'date_created',
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'class'=>'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'text-align: center'],
                    'template'=>'{restore}{delete-forever}',
                    'buttons' => [
                        'delete-forever' => function ($url, $model) {
                                /** @var ActionColumn $column */
                                return Html::a('<span class="glyphicon glyphicon-trash" style="font-size: 19px; padding-left: 10px"></span>', $url, [
                                    'title' => 'Delete',
                                    'data-confirm' => 'Are you sure to delete this item?',
                                    'data-method' => 'post',
                                ]);
                            },
                        'restore' => function ($url, $model) {
                                /** @var ActionColumn $column */
                                return Html::a('<span class="glyphicon glyphicon-upload" style="font-size: 19px; padding-left: 10px"></span>', $url, [
                                    'title' => 'Restore',
                                    'data-method' => 'post',
                                ]);
                            },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>