<?
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var product\models\Product[] $products */
/** @var product\models\forms\OrderCreate $model */
/** @var array $productsCount */

$this->registerJs(<<<JS
$('.increment').on('click', function(){
    totalAmount = 0;
    var productBlock = $(this).closest('.product');
    var resultBlock = $(this).closest('.counter-container').find('.count-result input');
    var count = parseInt(resultBlock.val());
    var price = parseInt(productBlock.find('.price').text());
    if (isNaN(count)) {
        return false;
    }
    count++;
    resultBlock.val(count);
    productBlock.find('.total-by-item').text(count * price);
    var totalsAmounts = $('.total-by-item');
    totalsAmounts.each(function(index, value){
        totalAmount += parseInt($(value).text())
    });
    $('.total-summ span').text(totalAmount);
});

$('.decrement').on('click', function(){
    totalAmount = 0;
    var productBlock = $(this).closest('.product');
    var resultBlock = $(this).closest('.counter-container').find('.count-result input');
    var count = parseInt(resultBlock.val());
    var price = parseInt(productBlock.find('.price').text());
    if (count === 0) {
        return false;
    }
    if (isNaN(count)) {
        return false;
    }
    count--;
    resultBlock.val(count);
    productBlock.find('.total-by-item').text(count * price);
    var totalsAmounts = $('.total-by-item');
    totalsAmounts.each(function(index, value){
        totalAmount += parseInt($(value).text())
    });
    $('.total-summ span').text(totalAmount);
});

$('.count-field').on('change', function(){
    totalAmount = 0;
    var productBlock = $(this).closest('.product');
    var resultBlock = $(this).closest('.counter-container').find('.count-result input');
    var count = parseInt(resultBlock.val());
    var price = parseInt(productBlock.find('.price').text());
    if (count === 0) {
        return false;
    }
    if (isNaN(count)) {
        return false;
    }
    resultBlock.val(count);
    productBlock.find('.total-by-item').text(count * price);
    var totalsAmounts = $('.total-by-item');
    totalsAmounts.each(function(index, value){
        totalAmount += parseInt($(value).text())
    });
    $('.total-summ span').text(totalAmount);
});

$("[data-mask='phone']").mask("+9(999) 999-99-99");

JS
);
$summaryCount = 0;
?>
<div class="order_page-conteiner" >
    <? $form = ActiveForm::begin(['id' => 'order-create-form'])?>
    <table class="order_page-conteiner-table">
        <tr style="background-color: rgb(248, 248, 248)">
            <td><h4 style="margin: 0; padding: 0;">Изображение</h4></td>
            <td><h4 style="margin: 0; padding: 0;">Название</h4></td>
            <td><h4 style="margin: 0; padding: 0;"> Цена за шт. ($)</h4></td>
            <td><h4 style="margin: 0; padding: 0;">Количество</h4></td>
            <td><h4 style="margin: 0; padding: 0;"> Цена итого: ($)</h4></td>
        </tr>
        <?foreach($products as $item):?>
            <?$product = $item['product']; $count = $item['count']?>
            <tr class="product">
                <td>
                    <?if($image = $product->getMainPhoto()):?>
                        <img src="<?=$image->getUrlBySize('small')?>" alt="<?=$image->alt?>" title="<?$image->title?>"/>
                    <?else:?>
                        <img src="http://placehold.it/150x150" alt="" />
                    <?endif?>
                </td>
                <td><?=$product->title?></td>
                <td class="price"><?=$product->price?></td>
                <td>
                    <div class="item-amount-conteiner counter-container" style="float: none;">
                        <span class="item-amount-minus decrement">-</span>
                        <span class="iten-amount-number count-result">
                            <?=Html::activeTextInput($model, "products[{$product->id}]", [
                                'class' => 'count-field',
                                'value' => (!empty($count))
                                        ? $count
                                        : 1,
                            ])?>
                        </span>
                        <span class="item-amount-plus increment">+</span>
                    </div>
                </td>
                <td class="total-by-item">
                    <?=($amount = $count * $product->price)?>
                    <?$summaryCount += $amount?>
                </td>
            </tr>
        <?endforeach?>
    </table>
    <div class="total-summ">Итого: $&nbsp;<span><?=$summaryCount?></span></div>
    <div class="clear line"></div>

        <?php echo $form->field($model,'username')->begin(); ?>
            <span class="order-input-descriotion">ФИО:</span>
            <?php echo Html::activeTextInput($model,'username', ['maxlength'=>255, 'placeholder' => 'введите Ваше имя', 'class' => 'order-input']); ?>
            <?php echo Html::error($model,'username', ['class' => 'help-block']); ?>
        <?php echo $form->field($model,'username')->end(); ?>
        <div class="clear"></div>

        <?php echo $form->field($model,'phone')->begin(); ?>
            <span class="order-input-descriotion">Контактный телефон:</span>
            <?php echo Html::activeTextInput($model,'phone', ['maxlength'=>255, 'data-mask' => "phone", 'placeholder' => 'введите Ваш телефон', 'class' => 'order-input']); ?>
            <?php echo Html::error($model,'phone', ['class' => 'help-block']); ?>
        <?php echo $form->field($model,'phone')->end(); ?>
        <div class="clear"></div>

        <?php echo $form->field($model,'email')->begin(); ?>
            <span class="order-input-descriotion">Контактный Email:</span>
            <?php echo Html::activeTextInput($model,'email', ['maxlength'=>255, 'placeholder' => 'введите Ваш e-mail', 'class' => 'order-input']); ?>
            <?php echo Html::error($model,'email', ['class' => 'help-block']); ?>
        <?php echo $form->field($model,'email')->end(); ?>
        <div class="clear"></div>
    <div class="clear line"></div>
    <?=Html::submitInput('Заказ подтверждаю', ['class' => 'itembuttonby'])?>
    <a href="/catalog"><div class="itembuttonsite">Продолжить выбирать</div></a>
    <div class="clear"></div>
    <?$form->end()?>
</div>