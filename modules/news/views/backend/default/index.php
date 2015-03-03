<?php

use backend\components\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var news\models\NewsSearch $searchModel
 * @var $row \news\models\News
 */
?>

<div class="table-wrapper news list">
    <div class="row filter-block">
        <h4 class="pull-left">News</h4>

        <div class="pull-left col-md-offset-1">
            <?= Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?=
        GridView::widget([
            'dataProvider'  => $dataProvider,
            'filterModel'   => $searchModel,
            'columns' => [
                [
                    'attribute' => 'preview_img',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($row) {
                            $src = ($row->getMainPhotoUrlBySize('xsmall'))
                                ? $row->getMainPhotoUrlBySize('xsmall')
                                : 'http://placehold.it/80x80';
                            return Html::img($src);
                        },
                    'format' => 'raw',
                    'filter' => false,
                ],
                [
                    'attribute' => 'title',
                    'value' => function($row) {
                            return Html::a($row->title, ['/news/default/update', 'id' => $row->id]);
                        },
                    'format' => 'raw',
                ],
                'is_enabled:boolean',
                'is_sended:boolean',
                'date_created',
                'date_updated',
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
            ],
        ]); ?>
    </div>
</div>