<?php
/**
 * @var yii\web\View $this
 * @var statical\models\Page $model
 */
if (!empty($model->css_file)) {
    $cssFile = str_replace('.css', '', $model->css_file);
    $this->registerCssFile("css/pages/{$cssFile}.css");
}
?>

<div class="body">
    <?if(!empty($model->view_file)):?>
        <?$blockFile = str_replace('.php', '', str_replace('.html', '', $model->view_file))?>
        <?=$this->render("blocks/{$blockFile}", ['model' => $model])?>
    <?else:?>
        <?=$model->content?>
    <?endif?>
</div>
