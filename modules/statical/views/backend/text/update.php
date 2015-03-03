<?php
/** @var yii\web\View $this */
/** @var statical\models\Text $model */
/** @var \backend\components\TBSForm $form */
use backend\components\Html;
use yii\helpers\Url;
use backend\widgets\ImperaviRedactorWidget;
?>

<div class="row">
    <h4 class="pull-left title">Text</h4>
</div>

<div class="row">
    <div
        class="col-md-10 column form-wrapper text">
        <?$form = \backend\components\TBSForm::begin();?>

            <?=$form->field($model, 'title')->textInput()?>
            <?=$form->field($model, 'alias')->textInput()?>
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
                    'imageUpload'              => Url::toRoute(['/statical/default/upload-img']),
                    'imageUploadErrorCallback' => 'js:function(obj){ alert(obj.error); }'

                ],
            ])?>
            <?=$form->field($model, 'is_available')->checkbox()?>
        
            <?=\backend\components\Html::submitButton('Save')?>
         or <?=\backend\components\Html::a('cancel', ['index'])?>

        <?\backend\components\TBSForm::end()?>
    </div>
</div>