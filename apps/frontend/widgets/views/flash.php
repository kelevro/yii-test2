<? /** @var \yii\web\View $this */ ?>
<?foreach($flashes as $key => $flash):?>
    <div class="alert alert-<?=$this->context->classForType($key)?> alert-white-alt rounded">
        <button class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon-exclamation fa <?=$this->context->iconForType($key)?>"></i>
        <strong><?=$this->context->getStatusMessage($key)?></strong>
        <?=\backend\components\Html::encode($flash)?>
    </div>
<?endforeach?>