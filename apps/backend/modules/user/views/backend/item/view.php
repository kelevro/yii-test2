<?php

use backend\components\Html;

/**
 * @var yii\web\View $this
 * @var user\models\auth\Item $model
 */
?>

<div class="item view col-md-10 col-lg-10 column">
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
                <label class="col-md-4 control-label">name</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->name?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">type</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->type?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">description</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->description?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">biz_rule</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->biz_rule?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">data</label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?=$model->data?>
                    </p>
                </div>
            </div>
                    </form>
    </div>

</div>

