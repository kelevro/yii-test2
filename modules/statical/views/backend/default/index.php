<?php

use backend\components\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var statical\models\PageSearch $searchModel
 * @var statical\models\Page $row
 */
?>

<div class="table-wrapper page list">
    <div class="row filter-block">
        <h4 class="pull-left">Pages</h4>
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
                            return Html::a($row->title, ['update', 'id' => $row->id]);
                        },
                    'format' => 'raw',
                ],
                'slug',
                'is_available:boolean',
                'date_created',
                'date_updated',
            ],
        ]); ?>
    </div>
</div>