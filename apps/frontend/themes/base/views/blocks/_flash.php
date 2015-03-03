<?php if (Yii::$app->session->hasFlash('success') || Yii::$app->session->hasFlash('error')):?>
    <?php if (Yii::$app->session->hasFlash('success')):?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success');?>
        </div>
    <?php endif?>
    <?php if (Yii::$app->session->hasFlash('error')):?>
        <div class="alert alert-error">
            <?=Yii::$app->session->getFlash('error');?>
        </div>
    <?php endif?>
<?php endif?>
