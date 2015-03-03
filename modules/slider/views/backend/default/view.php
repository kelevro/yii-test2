<?php

use backend\components\Html;

/*** @var yii\web\View $this* @var slider\models\Slider $model*/?>

<div class="slider view col-md-10 col-lg-10 column">
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
                            <?=$model->id?> </p>
                    </div>
                </div>
                            <div class="form-group">
                    <label class="col-md-4 control-label">image</label>

                    <div class="col-md-8">
                        <p class="form-control-static">
                            <?=$model->image?> </p>
                    </div>
                </div>
                            <div class="form-group">
                    <label class="col-md-4 control-label">weight</label>

                    <div class="col-md-8">
                        <p class="form-control-static">
                            <?=$model->weight?> </p>
                    </div>
                </div>
                            <div class="form-group">
                    <label class="col-md-4 control-label">alt</label>

                    <div class="col-md-8">
                        <p class="form-control-static">
                            <?=$model->alt?> </p>
                    </div>
                </div>
                            <div class="form-group">
                    <label class="col-md-4 control-label">title</label>

                    <div class="col-md-8">
                        <p class="form-control-static">
                            <?=$model->title?> </p>
                    </div>
                </div>
                            <div class="form-group">
                    <label class="col-md-4 control-label">url</label>

                    <div class="col-md-8">
                        <p class="form-control-static">
                            <?=$model->url?> </p>
                    </div>
                </div>
                            <div class="form-group">
                    <label class="col-md-4 control-label">date_created</label>

                    <div class="col-md-8">
                        <p class="form-control-static">
                            <?=$model->date_created?> </p>
                    </div>
                </div>
                            <div class="form-group">
                    <label class="col-md-4 control-label">date_updated</label>

                    <div class="col-md-8">
                        <p class="form-control-static">
                            <?=$model->date_updated?> </p>
                    </div>
                </div>
                    </form>
    </div>

</div>

