<?php
use backend\components\Html;
use yii\helpers\Url;
use backend\widgets\ImperaviRedactorWidget;

/** @var yii\web\View $this */
/** @var statical\models\Page $model */
/** @var \backend\components\TBSForm $form */
?>

<div class="row">
    <h4 class="pull-left title">Page</h4>
</div>

<div class="row">
    <div
        class="col-md-10 column form-wrapper page">
        <? $form = \backend\components\TBSForm::begin(); ?>

            <?=$form->field($model, 'title')->textInput()?>
            <?=$form->field($model, 'slug')->textInput()?>
            <?=$form->field($model, 'content')->textarea(['rows' => 24])?>
            <?=$form->field($model, 'is_available')->checkbox()?>
            <?=$form->field($model, 'view_file')->textInput()?>
            <?=$form->field($model, 'css_file')->textInput()?>
        
            <?=\backend\components\Html::submitButton('Save')?>
        or  <?=\backend\components\Html::a('cancel', ['index'])?>

        <?\backend\components\TBSForm::end()?>
    </div>
</div>