<?php
use backend\components\Html;
use common\assets\JqueryForm;

/** @var product\models\Category $model */
/** @var product\models\Attribute[] $attrs */
/** @var \backend\components\TBSForm $form */
/** @var yii\web\View $this */

JqueryForm::register($this);

$this->registerJs(<<<JS
$('#main').on('click', function(){
    $('#file_main_img').click();
});

$('#file_main_img').on('change', function(){
    $(this).closest('form').ajaxSubmit({
        url: '/product/category/upload-main-img',
        dataType: 'json',
        success: function(data)
        {
            if(data['status'] === 'success'){
                $('#preview_img').val(data['filename']);
                $('#main').attr('src', data['filelink']);
            } else {
                $('div.main_error').text(data['message']);
            }
        },
        error: function()
        {
             $('div.main_error').text('ERROR: unable to upload files');
        }
    });
});
JS
);

?>

<div class="row">
    <h4 class="pull-left title">Category</h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper category">
<?$form = \backend\components\TBSForm::begin();?>
    <?=$form->field($model, 'title')->textInput(['id' => 'category-title'])?>
    <div class="row">
        <div class="col-md-9">
            <?=$form->field($model, 'slug')->textInput(['id' => 'category-slug'])?>
        </div>
        <div class="col-md-3">
            <a href="#" class="generate-slug"
               data-url="/site/generate-slug"
               data-max-length="50"
               data-slug-field="category-slug"
               data-title-field="category-title">
                generate
            </a>
        </div>
    </div>
    <div class="row">
        <div class="field-box field-news-title">
            <label class="control-label" for="news-title">Main image</label>
            <div class="col-md-9">
                <?if($mainPhoto = $model->getMainPhotoUrlBySize('medium')):?>
                    <?=Html::img($mainPhoto, ['id' => 'main'])?>
                <?else:?>
                    <img src="http://placehold.it/300x300" alt="" id="main"/>
                <?endif?>
                <div class="main_error"></div>

            </div>
        </div>
    </div>
    <?=Html::hiddenInput("Category[img]", $model->img, ['id' => 'preview_img'])?>
    <?=$form->field($model, 'img_title')->textInput()?>
    <?=$form->field($model, 'img_alt')->textInput()?>
    <?=$form->field($model, 'is_enabled')->checkbox()?>
    <div class="col-md-12 column form-wrapper">
        <?=\seo\widgets\BackendSeoData::widget([
            'model'       => $model,
            'form'        => $form,
        ])?>
    </div>
<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>
<?if(!$model->isNewRecord && $model->lvl > 1):?>
    <?=\backend\components\Html::a('delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger pull-right',
        'data-confirm' => 'Are you sure delete it?'])?>
<?endif?>
<?\backend\components\TBSForm::end()?>
</div>
</div>
<?if($attrs):?>
    <div class="row">
        <h4 class="pull-left title">Attributes</h4>
    </div>
    <div class="row">
        <table class="table table-hover">
            <tbody>
            <!-- row -->
            <?foreach($attrs as $attr):?>
                <tr>
                    <td>
                        <?=$attr->title?>
                    </td>
                    <td>
                        <ul class="actions">
                            <li>
                                <a href="<?=\yii\helpers\Url::toRoute(['/product/attribute/update', 'id' => $attr->id])?>">
                                    Edit
                                </a>
                            </li>
                            <li class="last">
                                <a href="<?=\yii\helpers\Url::toRoute(['/product/attribute/delete', 'id' => $attr->id])?>">
                                    Delete
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    </div>
<?endif?>
<form id="form_main_img" method="post" enctype="multipart/form-data" style="opacity: 0; text-indent: -9999px">
    <input id="file_main_img" type="file" name="file"/>
</form>