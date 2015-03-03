<?php

use backend\components\Html;
use yii\grid\GridView;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var user\models\UserSearch $searchModel
 */
?>

<div class="table-wrapper partner list">
    <div class="row filter-block">
        <h4 class="pull-left">Users</h4>
        <div class="pull-left col-md-offset-1">
            <?=Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'email',
                    'value' => function($row) {
                        if ($row->project_id == null) {
                            $email = '<strong>'.$row->email.'</strong>';
                        } else {
                            $email = $row->email;
                        }
                        return Html::a($email, ['update', 'id' => $row->id]);
                    },
                    'format' => 'raw',
                ],
                [
                    'header' => 'Roles',
                    'value' => function($row) {
                        return implode(',', $row->getAssignedRoles());
                    },
                ],
                [
                    'header'        => 'Last login',
                    'attribute'     => 'date_last_login',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'format'        => 'datetime',
                ],
            ],
        ]); ?>
    </div>
</div>