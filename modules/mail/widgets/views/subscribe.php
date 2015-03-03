<?

use yii\helpers\Html;
use \common\assets\JqueryForm;
use frontend\themes\base\assets\BaseAsset;

/**
 * @var \yii\web\View $this
 * @var \mail\models\Subscriber $model
 */
JqueryForm::register($this);
$url = BaseAsset::register($this)->baseUrl;

$this->registerJs(<<<JS
$('.subscribe-button').on('click', function(e){
    e.preventDefault();
    $('.popup-conteiner').removeClass('hide');
    $('.popup-bg').removeClass('hide');
});

function closePopup()
{
    $('.popup-conteiner').addClass('hide');
    $('.popup-bg').addClass('hide');
}

$(this).keydown(function(e){
    if (e.which == 27) {
        closePopup();
    }
});

$('.popup-bg').on('click', closePopup);
$('.button-close').on('click', closePopup);

$('#subscribe-form').on('submit', function(){
    if ($(this).data('yiiActiveForm').validated) {
        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function()
            {
                $('.subscribe-submit').html('<img src="{$url}/img/ajax-loader-circle.jpg" alt=""/>');
            },
            success: function(responce){
                $('#subscribe-form').addClass('hide');
                $('.message-result')
                    .removeClass('hide')
                    .html('<img src="/images/green-ok-48.png" alt=""/>' + responce['message']);
                setTimeout(function(){
                    $('.popup-conteiner').addClass('hide');
                    $('.popup-bg').addClass('hide');
                }, 4000);
            },
            error: function(){
                $('.popup-conteiner').addClass('hide');
                $('.popup-bg').addClass('hide');
            }
        });
    }
    return false;
});
JS
);

?>

<div class="popup-conteiner hide">
    <div class="button-close">X</div>
    <p style="font-size: 20px; margin: 0; font-weight: 700; color: #666;">
        Подписка на новости
    </p>
    <? $form = \yii\widgets\ActiveForm::begin([
        'id' => 'subscribe-form',
        'action' => ['/mail/default/subscribe'],
        'method'    => 'post',
        'enableAjaxValidation' => true,
        'validationUrl' => ['/mail/default/validate'],
        'fieldConfig' => [
            'options' => ['class' => ''],
            'template' => "{input}\n{hint}\n{error}"
        ]
    ])?>
        <?php echo $form->field($model,'email')->begin(); ?>
        <?php echo Html::activeTextInput($model,'email', ['maxlength'=>255, 'placeholder' => 'Ваш E-Mail']); ?>
        <?php echo Html::error($model,'email', ['class' => 'help-block']); ?>
        <?php echo $form->field($model,'email')->end(); ?>
        <div style="clear: both"></div>
        <button style="margin-top: 8px;" type="submit" class="subscribe-submit">Подписаться</button>
    <? \yii\widgets\ActiveForm::end() ?>
    <div class="message-result hide"></div>
</div>
<div class="popup-bg hide"></div>