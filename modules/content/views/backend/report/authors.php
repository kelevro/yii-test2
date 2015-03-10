<?php

use backend\components\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dp
 * @var string $title
 */
?>

<div class="table-wrapper author list">
    <div class="row filter-block">
        <h4 class="pull-left"><?=$title?></h4>
    </div>
    <div class="row">
        <?= GridView::widget([
            'dataProvider' => $dp,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'name',
                    'value' => function($row) {
                        return Html::a($row->name, ['/content/book/update', 'id' => $row->id]);
                    },
                    'format' => 'raw',
                ],
                'date_created',
                'date_updated',
            ],
        ]); ?>
    </div>
</div>