<?php

use backend\components\Html;

/**
 * @var yii\web\View $this
 * @var user\models\User $model
 */
?>

<div class="user view col-md-10 col-lg-10 column">
    <div class="row">
        <h4 class="pull-left title">Title</h4>
        <div class="pull-left col-md-offset-1 col-xs-offset-1">
           <?=Html::a('Edit', ['update', 'id' => $model->id],
                ['class' => 'btn gray btn-flat', 'icon' => 'fa-pencil-square-o']) ?>
        </div>
    </div>


    <div class="row">
        <form class="form-horizontal col-md-6 column" role="form">
            <div class="form-group">
                <label class="col-md-4 control-label">id</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->id?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">project_id</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->project_id?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">email</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->email?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">password_hash</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->password_hash?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">auth_key</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->auth_key?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">is_deleted</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->is_deleted?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">date_created</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->date_created?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">date_updated</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->date_updated?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">date_last_login</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->date_last_login?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">date_deleted</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->date_deleted?>
                    </p>
                </div>
            </div>
                    </form>
    </div>

</div>

