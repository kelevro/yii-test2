<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass;
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->getTableSchema()->columnNames;
}

echo "<?php\n";
?>
use backend\components\Html;
/** @var yii\web\View $this */
?>

<div class="row">
    <h4 class="pull-left title"><?=StringHelper::basename($generator->modelClass)?></h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper <?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>">
<?="<?"?>
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */
/** @var \backend\components\TBSForm $form */
$form = \backend\components\TBSForm::begin();
?>

<?foreach($safeAttributes as $attribute):?>
    <?="<?="?>$form->field($model, '<?=$attribute?>')->textInput()?>
<?endforeach?>

<?="<?="?>\backend\components\Html::submitButton('Save')?> or <?="<?="?>\backend\components\Html::a('cancel', ['index'])?>

<?="<?"?>\backend\components\TBSForm::end()?>
</div>
</div>