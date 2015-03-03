<?php
use backend\components\Html;

/** @var yii\web\View $this */
/** @var product\models\forms\AttributeUpdate $model */
/** @var \backend\components\TBSForm $form */

$this->registerCss(<<<CSS
.attr-container input{
    float: left;
    display: inline;
    width: 90%;
}
.attr-container span{
    font-size: 19px;
    float: left;
    padding-left: 10px;
    display: inline;
    cursor: pointer;
    margin-top: 10px;
}
CSS
);

$this->registerJs(<<<JS
$('.attr-type').on('change', function(){
    $('.toggle-block').toggleClass('hide');
});

$('.add_value_button').on('click', function(){
    event.preventDefault();
    $('.selectable_field .block').append(
    '<div class="attr-container">'
    +'<input type="text" placeholder="value" class="form-control inline-input" name="AttributeUpdate[values][]">'
    +'<span class="glyphicon glyphicon-trash remove"></span></div>'
    );
});

$('.add_filter_button').on('click', function(){
    event.preventDefault();
    $('.filter_field .block').append(
    '<div class="attr-container">'
    +'<input type="text" placeholder="filter value" class="form-control inline-input" name="AttributeUpdate[filters][]">'
    +'<span class="glyphicon glyphicon-trash remove"></span></div>'
    );
});

$('.block').on('click', '.remove', function(){
    $(this).closest('.attr-container').remove();
});

JS
);

?>

<div class="row">
    <h4 class="pull-left title">Attribute</h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper attribute">
<?$form = \backend\components\TBSForm::begin();?>
    <?=$form->field($model, 'title')->textInput()?>
    <?=$form->field($model, 'category')->dropDownList(\product\models\Category::getRecordsList())?>
    <?=$form->field($model, 'is_selectable')->radioList([0=>'Editable', 1=>'Selectable'], ['class' => 'attr-type'])?>
    <div class="toggle-block selectable_field <?=($model->is_selectable)?'':'hide'?>">
        <div class="field-box">
            <label class="control-label" for=""></label>
            <div class="col-md-9">
                <div class="block">
                    <?if($model->values):?>
                        <?foreach($model->values as $id=>$value):?>
                            <div class="attr-container">
                                <input type="text" placeholder="value"  value="<?=$value?>"
                                       class="form-control inline-input" name="AttributeUpdate[values][<?=$id?>]">
                                <span class="glyphicon glyphicon-trash remove"></span>
                            </div>
                        <?endforeach?>
                    <?else:?>
                        <input type="text" placeholder="attribute value" class="form-control inline-input" name="AttributeUpdate[values][]">
                    <?endif?>
                </div>
                <div class="pull-right col-md-offset-1" style="padding: 5px;">
                    <?= Html::a('Add', '#', ['class' => 'btn btn-success btn-flat add_value_button', 'icon' => 'fa-plus']) ?>
                </div>
            </div>
        </div>
    </div>
    <br/><br/><br/>
    <div class="toggle-block <?=($model->is_selectable) ? 'hide' : ''?>">
        <div class="row">
            <h4 class="pull-left title">Filter</h4>
        </div>
        <div class="filter_field">
            <div class="field-box">
                <label class="control-label" for=""></label>
                <div class="col-md-9">
                    <div class="block">
                        <?if(!$model->attr->isNewRecord && !$model->is_selectable && $model->filters):?>
                            <?foreach($model->filters as $filterIdx => $filterValue):?>
                                <div class="attr-container">
                                    <input type="text" placeholder="filter value"  value="<?=$filterValue?>"
                                        class="form-control inline-input" name="AttributeUpdate[filters][<?=$filterIdx?>]">
                                    <span class="glyphicon glyphicon-trash remove"></span>
                                </div>
                            <?endforeach?>
                        <?else:?>
                            <input type="text" placeholder="filter value" class="form-control inline-input" name="AttributeUpdate[filters][]">
                        <?endif?>
                    </div>
                    <div class="pull-right col-md-offset-1" style="padding: 5px;">
                        <?= Html::a('Add', '#', ['class' => 'btn btn-success btn-flat add_filter_button', 'icon' => 'fa-plus']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>
<?if(!$model->attr->isNewRecord):?>
    <?=Html::a('delete', ['delete', 'id' => $model->attr->id], ['class' => 'btn btn-danger pull-right',
        'data-confirm' => 'Are you sure delete it?'])?>
<?endif?>

<?\backend\components\TBSForm::end()?>
</div>
</div>