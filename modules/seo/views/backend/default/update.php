<?
/** @var \yii\web\View $this */
/** @var \seo\models\SeoRule $model */
?>
<div class="row">
    <h4 class="pull-left title"><?=$model->title()?></h4>
</div>

<div class="col-md-10 column form-wrapper">

<?
/** @var \yii\web\View $this */
/** @var \seo\models\SeoRule $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin([
    'action' => ['/seo/default/update', 'id' => $model->id],
]);
?>

    <?=$this->render('_form', ['model' => $model, 'form' => $form])?>


<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>

</div>