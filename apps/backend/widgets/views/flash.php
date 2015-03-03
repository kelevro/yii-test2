<? /** @var \yii\web\View $this */ ?>
<?foreach($flashes as $key => $flash):?>
    <div class="alert alert-<?=$this->context->classForType($key)?>">
        <i class="icon-exclamation fa <?=$this->context->iconForType($key)?>"></i>
        <?=\backend\components\Html::encode($flash)?>
    </div>
<?endforeach?>