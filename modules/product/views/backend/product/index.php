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
        <h4 class="pull-left">Products</h4>

        <div class="pull-left col-md-offset-1">
            <?=\backend\components\Html::dropDownList('category', null, \product\models\Category::getRecordsList(),
                ['id' => 'product-select-category'])?>
            <?= Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat add-button', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid) {
                $result = [];
                if (strpos(\Y::request()->getUrl(), "rid={$model->id}") !== false) {
                    $result['style'] = 'border: 3px solid limegreen;';
                }
                $result['id'] = "row_{$model->id}";
                return $result;
            },
            'columns' => [
                [
                    'label' => 'image',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($row) {
                            /** @var Product $row */
                            $src = ($image = $row->getMainPhoto())
                                ? $image->getUrlBySize('xsmall')
                                : 'http://placehold.it/80x80';
                            return Html::a(Html::img($src), ['update', 'id' => $row->id]);
                        },
                    'format' => 'raw',
                    'filter' => false,
                ],
                [
                    'attribute' => 'price_id',
                    'headerOptions' => ['class' => 'col-md-2'],
                ],
                [
                    'attribute' => 'is_enabled',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'filter' => [0 => 'No', 1 => 'Yes'],
                    'value' => function ($row) {
                            return ($row->is_enabled)?'Yes':'No';
                        },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Attributes',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'filter' => [0 => 'No', 1 => 'Yes'],
                    'value' => function ($row) {
                            /** @var Product $row */
                            $result = false;
                            if ($row->attrs) {
                                foreach ($row->attrs as $attrVal) {
                                    if ($attrVal->value) {
                                        $result = true;
                                        break;
                                    }
                                }
                            }

                            return ($result)?'Yes':'No';
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Documentation',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'filter' => false,
                    'value' => function ($row) {
                            return ($row->getDocumentations()->count())?'Yes':'No';
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
                ],
            ],
        ]); ?>
    </div>
</div>