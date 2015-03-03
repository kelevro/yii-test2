<?php
use backend\components\Html;
use yii\helpers\Url;
use backend\widgets\ImperaviRedactorWidget;

/** @var yii\web\View $this */
/** @var news\models\News $model */
/** @var \backend\components\TBSForm $form */

$this->registerJs(<<<JS
$('#main').on('click', function(){
    $('#file_main_img').click();
});

$('#file_main_img').on('change', function(){
    $(this).closest('form').ajaxSubmit({
        url: '/news/default/upload-main-img',
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
    <h4 class="pull-left title">News</h4>
</div>

<div class="row">
    <div
        class="col-md-10 column form-wrapper news">
        <?
        $form = \backend\components\TBSForm::begin();
        ?>
            <?=$form->field($model, 'title')->textInput(['id' => 'new-title'])?>

            <div class="row">
                <div class="col-md-9">
                    <?=$form->field($model, 'slug')->textInput(['id' => 'new-slug'])?>
                </div>
                <div class="col-md-3">
                    <a href="#" class="generate-slug"
                       data-url="/site/generate-slug"
                       data-max-length="50"
                       data-slug-field="new-slug"
                       data-title-field="new-title">
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
            <?=$form->field($model, 'img_title')->textInput()?>
            <?=$form->field($model, 'img_alt')->textInput()?>

            <?=Html::hiddenInput("News[preview_img]", $model->preview_img, ['id' => 'preview_img'])?>

            <?=ImperaviRedactorWidget::widget([
                'form'      => $form,
                'model'     => $model,
                'attribute' => 'content',
                'fieldOptions' => ['class' => 'olololo'],
                'options'   => [
                    'toolbar'                  => 'classic',
                    'lang'                     => 'ru',
                    'minHeight'                => 800,
                    'imageGetJson'             => '',
                    'imageUpload'              => Url::toRoute(['/news/default/upload-img']),
                    'imageUploadErrorCallback' => 'js:function(obj){ alert(obj.error); }'

                ],
            ])?>

            <?=$form->field($model, 'is_enabled')->checkbox()?>
            <?=$form->field($model, 'is_sended')->checkbox()?>
            <div class="col-md-12 column form-wrapper">
                <?=\seo\widgets\BackendSeoData::widget([
                    'model'       => $model,
                    'form'        => $form,
                ])?>
            </div>
            <div class="field-box field-news-title">
                <label class="control-label" for="news-title"></label>
                <div class="col-md-9">
                    <?=\backend\components\Html::submitButton('Save')?> or <?=        \backend\components\Html::a('cancel', ['index'])?>
                </div>
                <?if(!$model->isNewRecord):?>
                    <?=Html::a('delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger pull-right',
                        'data-confirm' => 'Are you sure delete it?'])?>
                <?endif?>
            </div>
        <?\backend\components\TBSForm::end()?>
    </div>
</div>
<form id="form_main_img" method="post" enctype="multipart/form-data" style="opacity: 0; text-indent: -9999px">
    <input id="file_main_img" type="file" name="file"/>
</form>