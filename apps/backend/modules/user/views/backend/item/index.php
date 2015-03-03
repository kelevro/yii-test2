<?php

use backend\components\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var user\models\auth\ItemSearch $searchModel
 * @var array $tasks
 * @var array $roles
 */
?>

<div class="table-wrapper item list">
    <div class="row filter-block">
        <h4 class="pull-left">Items</h4>
        <div class="pull-left col-md-offset-1">
            <?=Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'rowOptions'   => function($model, $key, $index, $grid) {
                    return [
                        'class' => ($index % 2 ? 'odd' : null) . ' type-' . $model->type,
                    ];
                },
            'columns' => [
                [
                    'attribute' => 'name',
                    'value' => function($row) {
                        return Html::a($row->name, ['update', 'id' => $row->name]);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute'     => 'type',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'filter'        => \user\models\auth\Item::types(),
                    'value'         => function ($row) {
                        return $row->getTypeTitle();
                    },
                ],
                [
                    'value' => function($row) {
                        return Html::a('delete', ['delete', 'id' => $row->name], [
                            'data-confirm' => 'Really delete?',
                        ]);
                    },
                    'format' => 'raw',
                ],
            ],
        ]); ?>
    </div>
</div>



<div class="row filter-block">
    <h4 class="pull-left">Assignment</h4>
</div>

<br/>
<div class="row ctrls">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#roles">Roles</a></li>
        <li class=""><a href="#tasks">Tasks</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="roles">
            <div class="row role-block manage-block"
                 data-list-url="<?=Url::to(['list', 'type' => \user\models\auth\Item::TASK])?>"
                 data-assign-url="<?=Url::to(['manage-child', 'type' => \user\models\auth\Item::TASK, 'action' => 'assign'])?>"
                 data-remove-url="<?=Url::to(['manage-child', 'type' => \user\models\auth\Item::TASK, 'action' => 'remove'])?>"
            >
                <div class="column col-md-5">
                    <h5>Role</h5>
                    <?=Html::dropDownList('', null, $roles, [
                        'class' => 'key-list col-md-11', 'size' => 10,
                    ])?>
                </div>
                <div class="column col-md-3">
                    <h5>Assigned tasks</h5>
                    <select size="10" class="col-md-12 assigned"></select>
                </div>
                <div class="column col-md-1">
                    <br/><br/><br/><br/>
                    <button class="col-md-12 btn btn-success assign">&lt;&lt;</button>
                    <br/><br/>
                    <button class="col-md-12 btn btn-warning remove">&gt;&gt;</button>
                </div>
                <div class="column col-md-3">
                    <h5>Available tasks</h5>
                    <select size="10" class="col-md-12 available"></select>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="tasks">
            <div class="row task-block manage-block"
                 data-list-url="<?=Url::to(['list', 'type' => \user\models\auth\Item::OPERATION])?>"
                 data-assign-url="<?=Url::to(['manage-child', 'type' => \user\models\auth\Item::OPERATION, 'action' => 'assign'])?>"
                 data-remove-url="<?=Url::to(['manage-child', 'type' => \user\models\auth\Item::OPERATION, 'action' => 'remove'])?>"
                >
                <div class="column col-md-5">
                    <h5>Task</h5>
                    <?=Html::dropDownList('', null, $tasks, [
                        'class' => 'key-list col-md-11', 'size' => 10,
                    ])?>
                </div>
                <div class="column col-md-3">
                    <h5>Assigned operations</h5>
                    <select size="10" class="col-md-12 assigned"></select>
                </div>
                <div class="column col-md-1">
                    <br/><br/><br/><br/>
                    <button class="col-md-12 btn btn-success assign">&lt;&lt;</button>
                    <br/><br/>
                    <button class="col-md-12 btn btn-warning remove">&gt;&gt;</button>
                </div>
                <div class="column col-md-3">
                    <h5>Available operations</h5>
                    <select size="10" class="col-md-12 available"></select>
                </div>
            </div>
        </div>
    </div>


</div>
