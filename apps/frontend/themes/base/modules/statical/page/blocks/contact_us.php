<?
use yii\helpers\Html;

?>
<?= $model->content ?>
<div class="contact_us">
    <?=Html::beginForm(['/site/contact-us'], 'post')?>
        <label for="email">E-mail:</label>
        <p><?=Html::activeTextInput($model1, 'email', ['id' => 'email'])?></p>
        <label for="phone">Phone:</label>
        <p><?=Html::activeTextInput($model1, 'phone', ['id' => 'phone'])?></p>
        <p><?=Html::activeTextarea($model1, 'content', ['cols'=>"30", 'rows'=>"4"])?></p>
        <input type="submit" value="Отправить"/>
    <?Html::endForm()?>

</div>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?108"></script>

    <!-- VK Widget -->
    <div id="vk_groups"></div>
    <script type="text/javascript">
    VK.Widgets.Group("vk_groups", {mode: 0, width: "220", height: "400", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 43760669);
    </script>
