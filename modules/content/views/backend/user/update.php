<?php
/** @var yii\web\View $this */
/** @var content\models\User $model */
/** @var \backend\components\TBSForm $form */
?>

<div class="row">
    <h4 class="pull-left title">User</h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper user">
<?$form = \backend\components\TBSForm::begin();?>

    <?=$form->field($model, 'name')->textInput()?>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>
</div>