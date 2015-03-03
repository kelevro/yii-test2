<?php
use backend\components\Html;
/** @var yii\web\View $this */
?>

<div class="row">
    <h4 class="pull-left title">Item</h4>
</div>

<div class="row">

<div class="col-md-10 column form-wrapper">
<?/** @var user\models\auth\Item $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin();
?>

    <?=$form->field($model, 'name')->textInput()?>
    <?=$form->field($model, 'type')->dropDownList($model->types())?>
    <?=$form->field($model, 'description')->textInput()?>
    <?=$form->field($model, 'biz_rule')->textInput()?>
    <?=$form->field($model, 'data')->textInput()?>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>


<div class="col-md-2 column form-wrapper">
    desc
</div>
</div>