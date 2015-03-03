<?php

use backend\components\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var product\models\AttributeSearch $searchModel
 */
?>

<div class="table-wrapper attribute list">
    <div class="row filter-block">
        <h4 class="pull-left">Attributes</h4>

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
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'title',
                    'value' => function($row) {
                            /** @var \product\models\Attribute $row */
                            return Html::a($row->title, ['update', 'id' => $row->id]);
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'category_id',
                    'filter'    => \product\models\Category::getRecordsList(),
                    'value' => function($row) {
                            /** @var \product\models\Attribute $row */
                            return Html::a($row->category->title, ['/product/category/update', 'id' => $row->category_id]);
                        },
                    'format' => 'raw',
                ],
                'date_created',
            ],
        ]); ?>
    </div>
</div>