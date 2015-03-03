<?
/** @var \yii\web\View $this */
/** @var \yii\base\Model $model */
/** @var \seo\models\SeoRule $seoData */
/** @var \yii\widgets\ActiveForm $form */

$seoData = $model->seoData;
?>

<div class="seo-data-widget-backend" data-exist="<?=$seoData->getIsHasData() ? 'true' : 'false'?>">
    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <h4 class="pull-left title col-md-2">
            <?= $form->field($seoData, 'enabled', [
                'template' => '{input}',
                'options'  => ['class' => 'pull-left']
            ])->checkbox(['class' => 'enable-seo'], false) ?>
            &nbsp;
            <span class="title-label">SEO Data</span>
        </h4>
    </div>

    <div class="row">
        <div class="col-md-10 column form-wrapper">
            <?=
            $this->render('@seo/views/backend/default/_form.php', [
                'model'     => $seoData,
                'form'      => $form,
                'showRoute' => false,
            ])?>
        </div>
    </div>
</div>