<?php
use backend\components\Html;
/** @var yii\web\View $this */
?>

<div class="row">
    <h4 class="pull-left title">DocumentationCategory</h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper documentation-category">
<?/** @var product\models\DocumentationCategory $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin();
?>

    <?=$form->field($model, 'title')->textInput(['id' => 'doc-cat-title'])?>
    <div class="row">
        <div class="col-md-9">
            <?=$form->field($model, 'slug')->textInput(['id' => 'doc-cat-slug'])?>
        </div>
        <div class="col-md-3">
            <a href="#" class="generate-slug"
               data-url="/site/generate-slug"
               data-max-length="50"
               data-slug-field="doc-cat-slug"
               data-title-field="doc-cat-title">
                generate
            </a>
        </div>
    </div>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>
</div>