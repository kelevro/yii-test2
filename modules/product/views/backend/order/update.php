<?php
use backend\components\Html;
/** @var yii\web\View $this */
?>

<div class="row">
    <h4 class="pull-left title">Order</h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper order">
<?/** @var product\models\Order $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin();
?>

    <?=$form->field($model, 'is_closed')->textInput()?>
    <?=$form->field($model, 'is_deleted')->textInput()?>
    <?=$form->field($model, 'date_created')->textInput()?>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>
</div>