<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\Storage;
use slider\assets\backend\Asset;


/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var slider\models\SliderSearch $searchModel
 */

Asset::register($this);

$this->title = 'Sliders';
$this->params['breadcrumbs'][] = $this->title;
$countImages = count($images);
$this->registerJs(<<<JS
counter = {$countImages};

file_upload_click = function(e){
    var id = $(e.target).parents('div.image').attr('id').split('_')[1];
    console.log(id);
    console.log($('form_'+id+' input'));
    $('.form_'+id+' input').click();
}

upload_file = function(e){
    var form = $(e.target).parents('form');
    var id = form.attr('class').split('_')[1];
    form.ajaxSubmit({
        url: '/slider/default/upload-img',
        dataType: 'json',
        success: function(data)
        {
            if(data['status'] === 'success'){
               $('#image_'+id+' label').remove();
               $('#image_'+id+' img').remove();
               $('#image_'+id).append('<img src='+data['filelink']+' class=\"uploader_btn\"/>');
               $('.img_name_'+id).val(data['filename']);
            } else {
                console.log('trubla');
            }
        },
        error: function()
        {
            form.find('div.message').text('ERROR: unable to upload files');
        }
    });
};

$('.uploader_btn').on('click', file_upload_click);

$('.uploader').on('change', upload_file);


$('#add_element').click(function(e){
    e.preventDefault();
    var arr = [];
    $('#sortable li div.image_block').each(function(id, elm){
        arr.push($(elm).attr('id')*1);
    });
    console.log(arr);
    console.log(Math.max.apply(Math, arr));
    var id = Math.max.apply(Math, arr) + 1;

    counter = counter + 1;
    $('#sortable li:last-of-type').after(
        '<li><section><div class="image" id="image_'+counter+'">'
        + '<label class="uploader_btn" id="label_'+counter+'" onclick="file_upload_click(event)"></label></div>'
        + '<div class="labels"><input name="Slider['+counter+'][image]" '
        + 'type="hidden" class="img_name_'+counter+'"/>'
        + '<label>Link:<input name="Slider['+counter+'][url]" type="text"/></label>'
        +'<label>Alt:<input name="Slider['+counter+'][alt]" type="text"/></label>'
        +'<label>Title:<input name="Slider['+counter+'][title]" type="text"/></label>'
        + '<input name="Slider['+counter+'][weight]" type="hidden"/>'
        + '<div class="pull-right"><button class="btn-flat danger" onclick="$(this).parents(\'li\').remove();">Удалить</button></div></div></section></li>'
    );

    $('div.forms').append(
        '<form action=\"/slider/default/upload-img\" enctype=\"multipart/form-data\" method=\"post\" class=\"form_'+counter+'\">'
        + '<input name=\"file\" type=\"file\" class=\"uploader\" onchange=\"upload_file(event)\"></form>'
    );

});

$('.remove').on('click', function (){
    $(this).parents('li').remove();
});

$('.boo').submit(function(){
    var sort=$('#sortable li');
    for(var i=0; i<sort.length; i++){
        $(sort[i]).find('input.sort').val(i);
    }
    return true;
});

$('#sortable').sortable();

$('#sortable').disableSelection();
JS
);
?>

<div class="forms" style="display: none">
    <? if(empty($images)): ?>
        <form action="<?= Url::toRoute(['/slider/default/upload-img']) ?>" enctype="multipart/form-data" method="post" class="form_0">
            <input name="file" type="file" class="uploader">
        </form>
    <?else:?>
        <?foreach($images as $key => $image):?>
            <form action="<?= Url::toRoute(['/slider/default/upload-img']) ?>" enctype="multipart/form-data" method="post" class="form_<?=$key?>">
                <input name="file" type="file" class="uploader">
            </form>
        <?endforeach?>
    <?endif?>
</div>

<div class="slider-index">
    <form action="<?= Url::toRoute(['/slider/default/index']) ?>" enctype="multipart/form-data" method="post" class="boo">
        <?=Html::hiddenInput('is_post', true)?>
        <div id="cont">
            <ul id="sortable" style="list-style: none; box-sizing: border-box; margin-left: 0">
                <? if(empty($images)): ?>
                    <li>
                        <section>
                            <div class="image" id="image_0">
                                <label class="uploader_btn"></label>
                            </div>
                            <div class="labels">
                                <label>Link:<input name="Slider[0][url]" type="text"/></label>
                                <label>Alt:<input name="Slider[0][alt]" type="text"/></label>
                                <label>Title:<input name="Slider[0][title]" type="text"/></label>
                                <input name="Slider[0][image]" type="hidden"  class="img_name_0"/>
                                <input name="Slider[0][weight]" type="hidden"/>
                                <div class="pull-right"><button class="btn-flat danger remove">Удалить</button></div>
                            </div>
                        </section>
                    </li>
                <? else: ?>
                    <? foreach($images as $key => $image): ?>
                        <li>
                            <section>
                                <div class="image" id="image_<?=$key?>">
                                    <img src="<?=Storage::getStorageUrlTo('/slider/thumb/' . $image['image'])?>"
                                         alt="<?=$image['alt']?>" class="uploader_btn"/>
                                </div>
                                <div class="labels">
                                    <label>Link:
                                        <input name="Slider[<?=$key?>][url]" type="text" value="<?=$image['url']?>"/>
                                    </label>
                                    <label>Alt:
                                        <input name="Slider[<?=$key?>][alt]" type="text" value="<?=$image['alt']?>"/>
                                    </label>
                                    <label>Tile:
                                        <input name="Slider[<?=$key?>][title]" type="text"  value="<?=$image['title']?>"/>
                                    </label>
                                    <input name="Slider[<?=$key?>][image]" type="hidden" value="<?=$image['image']?>" class="img_name_<?=$key?>"/>
                                    <input name="Slider[<?=$key?>][weight]" type="hidden"/>
                                    <div class="pull-right"><button class="btn-flat danger remove">Удалить</button></div>
                                </div>
                            </section>
                        </li>
                    <? endforeach ?>
                <? endif ?>
            </ul>
        </div>
        <input id="sub" class="btn btn-flat success" type="submit" value="Сохранить изменения"/>
        <a href="#" id="add_element" class="btn-flat primary">Добавить</a>
    </form>

</div>
