<?php
use backend\components\Html;/** @var yii\web\View $this */?>

<div class="row">
    <h4 class="pull-left title">Slider</h4>
</div>

<div class="row">
    <div
        class="col-md-10 column form-wrapper slider">
        <?        /** @var slider\models\Slider $model */
        /** @var \backend\components\TBSForm $form */
        $form = \backend\components\TBSForm::begin();
        ?>

                    <?=$form->field($model, 'image')->textInput()?>
                    <?=$form->field($model, 'weight')->textInput()?>
                    <?=$form->field($model, 'date_created')->textInput()?>
                    <?=$form->field($model, 'alt')->textInput()?>
                    <?=$form->field($model, 'title')->textInput()?>
                    <?=$form->field($model, 'url')->textInput()?>
                    <?=$form->field($model, 'date_updated')->textInput()?>
        
        <?=\backend\components\Html::submitButton('Save')?> or <?=        \backend\components\Html::a('cancel', ['index'])?>

        <?\backend\components\TBSForm::end()?>
    </div>
</div>