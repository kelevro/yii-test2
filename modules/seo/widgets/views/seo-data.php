<?
/** @var \yii\web\View $this */
/** @var \seo\models\SeoRule $model */
?>
<div class="seo-data-widget">
<div class="seo-data-edit <?if($hasData):?>has-data<?endif?>">
    <a href="#seoForm" role="button" data-toggle="modal">Seo Data</a>
</div>

<? \yii\bootstrap\Modal::begin(['id' => 'seoForm', 'header' => 'Edit SEO data']) ?>
    <div class="row">
    <div class="col-md-10 column form-wrapper">

    <? $form = \yii\widgets\ActiveForm::begin([
        'action' => ['/seo/widget/update', 'model' => $model->className(), 'id' => $model->id],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
    ]) ?>

    <div class="hidden">
    <?=$form->field($model, 'route')->textInput()?>
    <?foreach($model->routeAttributes() as $attr):?>
        <?=$form->field($model, $attr)->textInput()?>
    <?endforeach?>
    </div>

    <?=$this->render('@seo/views/backend/default/_form.php', [
        'model'     => $model,
        'form'      => $form,
        'showRoute' => false,
    ])?>

    <?=\yii\bootstrap\Button::widget(['label' => 'Save', 'options' => ['class' => 'btn-success']])?>

    <? \yii\widgets\ActiveForm::end()?>
    </div>
    </div>
<? \yii\bootstrap\Modal::end() ?>
</div>