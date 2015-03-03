<?php
use backend\components\Html;
/** @var yii\web\View $this */
?>

<div class="row">
    <h4 class="pull-left title">User</h4>
</div>

<div class="col-md-10 column form-wrapper">
<?/** @var user\models\User $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>
    <div class="row">
        <div class="col-md-12 column form-wrapper">
            <?=$form->field($model, 'first_name')->textInput()?>
            <?=$form->field($model, 'last_name')->textInput()?>
            <?=$form->field($model, 'sex')->dropDownList(\user\models\User::getSexList())?>
            <?=$form->field($model, 'signature')->textarea()?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 column form-wrapper">
            <?=$form->field($model, 'email')->textInput()?>
            <?=$form->field($model, 'password', ['options' => ['class' => 'field-box no-margin']])
                ->textInput()->hint('Enter new password if you want to change it')?>

            <?=$form->field($model, 'is_deleted')->checkbox()?>
        </div>
        <div class="col-md-12 column form-wrapper">
            <label class="control-label" for="user-filephoto">Photo</label>
            <div class="col-md-9">
                <?if($model->has_photo):?>
                    <?=Html::img($model->getPhotoUrl(), ['id' => 'main'])?>
                <?else:?>
                    <img src="http://placehold.it/100x100" alt="" id="main"/>
                <?endif?>
                <div class="main_error"></div>
                <?=Html::activeFileInput($model, 'filePhoto')?>
            </div>
        </div>
    </div>
    <div class="row">
        <h4 class="pull-left title">Rights</h4>
    </div>

    <div class="row">
        <div class="col-md-12 column form-wrapper">
            <?=$form->field($model, 'roles')->checkboxList($model->getAvailableRoles(), ['class' => 'checkbox-inline'])?>
        </div>
    </div>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>
