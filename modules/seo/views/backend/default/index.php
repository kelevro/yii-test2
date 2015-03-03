<?php

use backend\components\Html;
use yii\grid\GridView;
\seo\assets\ModuleAsset::register($this);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var seo\models\SeoRulesSearch $searchModel
 */
?>


<div class="table-wrapper seo-rules list">
    <div class="row filter-block">
        <h4 class="pull-left">Seo rules</h4>
        <div class="pull-left col-md-offset-1 col-xs-offset-1">

            <div class="ui-select">
                <?=\backend\components\Html::dropDownList('seo-model', null, $searchModel->getModelsList(),
                    ['id' => 'seo-model-select'])?>
            </div>

            <?= Html::a('Add', ['update'], ['class' => 'btn btn-success btn-flat seo-model-add', 'icon' => 'fa-plus']) ?>
        </div>
    </div>
    <div class="row">
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($row) {
                            return $row->id;
                        },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'route',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'value' => function($row) {
                        /** @var \seo\models\SeoRule $rule */
                        return Html::a($row->route, ['update', 'id' => $row->id]);
                    },
                    'format' => 'raw',
                    'filter' => $searchModel->getRoutesList(),
                ],
                [
                    'attribute' => 'meta_title',
                    'headerOptions' => ['class' => 'col-md-4'],
                ],
                [
                    'header'        => 'Date created',
                    'attribute'     => 'date_created',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'format'        => 'datetime',
                ],
            ],
        ]); ?>
    </div>

</div>
