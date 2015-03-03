<?php

use backend\components\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var statical\models\TextSearch $searchModel
 */
?>

<div class="table-wrapper text list">
    <div class="row filter-block">
        <h4 class="pull-left">Texts</h4>

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
                            /** @var \statical\models\Text $row */
                            return Html::a($row->title, ['update', 'id' => $row->id]);
                        },
                    'format' => 'raw',
                ],
                'alias',
                'is_available:boolean',
                 'date_created',
                 'date_updated',
            ],
        ]); ?>
    </div>
</div>