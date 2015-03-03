<?
/** @var \yii\web\View $this */
/** @var \seo\models\SeoRule $model */
/** @var \backend\components\TBSForm $form */
?>

<?if(!empty($showRoute)):?>
    <?=$form->field($model, 'route')->dropDownList($model->getRoutesWithTitles())?>
<?endif?>

<?=$form->field($model, 'meta_title')->textarea()?>
<?=$form->field($model, 'meta_desc')->textarea(['rows' => 4])?>

<?if($view = $model->viewFile()):?>
    <?=$this->render($view, ['model' => $model, 'form'  => $form])?>
<?endif?>
