<?php
use backend\components\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var product\models\forms\ProductUpdate $model */
/** @var \backend\components\TBSForm $form */
$model->getFormAttributes();

common\assets\Select2::register($this);

$docs = [];
foreach ($model->documentations as $k => $v) {
    $docs[] = ['id' => $k, 'text' => $v];
}
$docs = \yii\helpers\Json::encode($docs);

$relatedProducts = [];
foreach ($model->relatedProducts as $k => $v) {
    $relatedProducts[] = ['id' => $k, 'text' => $v];
}
$relatedProducts = \yii\helpers\Json::encode($relatedProducts);

$this->registerJs(<<<JS

$('#product-update-form').submit(function(e){
    $.each($('#fileupload .files .template-download'), function(idx, elm){
        var value,
        modelId = $(elm).find('.modelId').val(),
        title   = $(elm).find('.title-field').val(),
        alt     = $(elm).find('.alt').val();
        value   = JSON.stringify({title: title, alt: alt});
        $('.images-container').append(
        '<input type="hidden" name="ProductUpdate[images]['+modelId+']" value='+ value +'>'
        );
    });
});

$('.documentationText').select2({
    placeholder: 'select documentation',
    multiple: true,
    ajax: {
        url: '/product/documentation/doc-search-ajax',
        dataType: 'json',
        quietMillis: 100,
        data: function (term) {
            return {q: term};
        },
        results: function (data) {
            return {results: data.data.docs};
        }
    }
}).select2('data', {$docs});

$('.relatedProductsText').select2({
    placeholder: 'select related products',
    multiple: true,
    ajax: {
        url: '/product/product/related-search-ajax',
        dataType: 'json',
        quietMillis: 100,
        data: function (term) {
            return {q: term};
        },
        results: function (data) {
            return {results: data.data.products};
        }
    }
}).select2('data', {$relatedProducts});

JS
);

?>

<div class="row">
    <h4 class="pull-left title">Product</h4>
    <?if($model->product->is_deleted):?>
        <?= Html::a('Restore', ['restore', 'id' => $model->product->id], ['class' => 'btn btn-success btn-flat add-button']) ?>
        <?= Html::a('Delete Forever', ['delete-forever', 'id' => $model->product->id], ['class' => 'btn danger btn-flat']) ?>
    <?endif?>
</div>
<?=\backend\widgets\JqueryFileUploader::widget([
    'fileName'  => '@product/widgets/view/views/jquery-file-uploader.php',
    'saveUrl'   => Url::toRoute(['/product/product/upload-image']),
    'loadUrl'   => Url::toRoute(['/product/product/load-images', 'product' => $model->product->id]),
])?>
<div class="row">
<div class="col-md-10 column form-wrapper product">
<?$form = \backend\components\TBSForm::begin(['id' => 'product-update-form', 'enableClientValidation' => false]);?>
    <?=$form->field($model, 'title')->textInput(['id' => 'product-title'])?>
    <div class="row">
        <div class="col-md-9">
            <?=$form->field($model, 'slug')->textInput(['id' => 'product-slug'])?>
        </div>
        <div class="col-md-3">
            <a href="#" class="generate-slug"
               data-url="/site/generate-slug"
               data-max-length="50"
               data-slug-field="product-slug"
               data-title-field="product-title">
                generate
            </a>
        </div>
    </div>
    <?=$form->field($model, 'priceId')->textInput()?>
    <div class="hide">
        <?=$form->field($model, 'category')
            ->dropDownList(\product\models\Category::getRecordsList(), ['disabled' => 'disabled'])?>
    </div>
    <?=$form->field($model, 'is_enabled')->checkbox()?>
    <?=$form->field($model, 'description')->textarea(['rows' => 5])?>
    <?=$form->field($model, 'price')->textInput()?>
    <?=$form->field($model, 'producer')->textInput()?>
    <?=$form->field($model, 'wholesale')->textInput()?>
    <?=$form->field($model, 'small_wholesale')->textInput()?>
    <?=$form->field($model, 'count')->textInput()?>
    <?=$form->field($model, 'documentationText')
        ->textInput(['class' => 'documentationText col-md-12', 'multiple' => 'multiple','value' => ''])?>
    <?=$form->field($model, 'relatedProductsText')
        ->textInput(['class' => 'relatedProductsText col-md-12', 'multiple' => 'multiple','value' => ''])?>

    <?if($attrs = $model->getFormAttributes()):?>
        <?=$this->render('_attributes', ['model' => $model, 'attrs' => $attrs])?>
    <?endif?>
    <div class="images-container"></div>
    <?if(false):?>
        <div class="col-md-12 column form-wrapper">
            <?=\seo\widgets\BackendSeoData::widget([
                'model'       => $model->product,
                'form'        => $form,
            ])?>
        </div>
    <?endif?>
<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['list'])?>
    <?if(!$model->product->isNewRecord):?>
        <?=Html::a('delete', ['delete', 'id' => $model->product->id], ['class' => 'btn btn-danger pull-right',
            'data-confirm' => 'Are you sure delete it?'])?>
    <?endif?>
<?\backend\components\TBSForm::end()?>
</div>
</div>