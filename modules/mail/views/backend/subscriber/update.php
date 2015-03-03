<?php
use backend\components\Html;
/** @var yii\web\View $this */
?>

<div class="row">
    <h4 class="pull-left title">Subscriber</h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper subscriber">
<?/** @var mail\models\Subscriber $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin();
?>

    <?=$form->field($model, 'email')->textInput()?>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>
</div>