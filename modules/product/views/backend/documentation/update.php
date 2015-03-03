<?php
use backend\components\Html;

/** @var yii\web\View $this */
/** @var product\models\Documentation $model */

common\assets\Utils::register($this);

?>

<div class="row">
    <h4 class="pull-left title">Documentation</h4>
    <div class="pull-left col-md-offset-1 col-xs-offset-1">
        <a class="btn btn-success btn-flat"
           href="<?=\common\helpers\Storage::getStorageUrlTo('documentation') . '/' . $model->link?>"
           icon="fa-plus">
            <i class="fa fa-plus"></i> View
        </a>
    </div>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper documentation">
<?
/** @var product\models\Documentation $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>

    <?=$form->field($model, 'category_id')->dropDownList(\product\models\DocumentationCategory::getRecordsList())?>
    <?=$form->field($model, 'file')->fileInput()?>
    <?=$form->field($model, 'title')->textInput()?>

<?=\backend\components\Html::submitButton('Save')?>
    &nbsp;
<?=Html::a('Save and continue edit', '#',
    ['data-action' => \yii\helpers\Url::to(['update', 'continue' => 1]),
        'class' => 'btn-flat gray'])?>
    or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>
</div>