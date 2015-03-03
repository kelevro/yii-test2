<?
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */

$this->registerJs(<<<JS

JS
);
?>
<div class="row">
    <h4 class="pull-left title">Products Import</h4>
</div>
<?$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])?>
    <?=\yii\helpers\Html::fileInput('import')?>
    <?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>
<?$form->end()?>
<br/><br/>