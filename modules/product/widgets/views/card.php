<?
use yii\helpers\ArrayHelper;

/** @var $this \yii\web\View */
/** @var array $products */

$url = \frontend\themes\base\assets\BaseAsset::register($this)->baseUrl;

$this->registerJs(<<<JS

$('.add_to_cart').on('click', function(e){
    e.preventDefault();
    var product_id = $(this).data('product_id');
    var count    = $(this).data('count');
    addToCard(this, product_id, count);
    $('.cardio').addClass('show')
    setTimeout(function(){
       $('.cardio').removeClass('show');
    }, 3000);
});

$('.cart_more').on('click', '.del-from-card', function(e){
    e.preventDefault();
    var product_id = $(this).data('product_id');
    removeFromCard(product_id);
});


$('.cardio').mouseover(function(){
    // $('.cart_more').removeClass('hide');
    $('.cardio').addClass('show')

});
$('.cardio').mouseleave(function(){
    $('.cardio').removeClass('show');
    // $('.general-card').removeClass("show");
});

JS
);
?>

<div class="oder-list-conteiner cart_more cardio">
    <div class="oder-list-bottom-row <?=(!empty($products['products']))?'': 'hide'?>">
        <div class="oder-list-bottom-row-order">
            <a href="<?=\yii\helpers\Url::toRoute(['/product/order/create'])?>">ОФОРМИТЬ ЗАКАЗ ></a>
        </div>
    </div>
    <div class="items-container">
        <?if(!empty($products['products'])):?>
            <?foreach($products['products'] as $product):?>
                <div class="oder-list-item-conteiner item">
                    <div class="oder-list-item-button_close del-from-card" data-product_id="<?=$product['id']?>" title="Удалить товар из корзины">X</div>
                    <div class="clear" style="height: 10px;"></div><!--отступ-->
                    <img src="<?=$product['img']?>" alt=""/>
                    <div><?=$product['title']?></div>
                    <div>$&nbsp;<?=$product['price']?></div>
                    <div><?=$product['count']?> (шт)</div>
                    <div class="clear"></div>
                </div>
            <?endforeach?>
        <?endif?>
    </div>
    <div class="oder-list-bottom-row <?=(!empty($products['products']))?'': 'hide'?>">
        <div class="oder-list-bottom-row-total_summ">Итого: $&nbsp;<span><?=(!empty($products['summaryCost']))?:0?></span></div>
        <div class="oder-list-bottom-row-order">
            <a href="<?=\yii\helpers\Url::toRoute(['/product/order/create'])?>">ОФОРМИТЬ ЗАКАЗ ></a>
        </div>
    </div>
    <div class="card-empty-msg <?=(empty($products['products']))?'': 'hide'?>">Корзина пуста</div>
</div>

<div class="general-card cardio">
    <div class="basket"></div>
    <span>МОЯ КОРЗИНА (<span class="basket-all-cont"><?=(!empty($products['summaryCount']))?$products['summaryCount']:0?></span>)</span>
</div>


<div class="card-rk-button <?=(!empty($products['products']))?:'hide'?>">
    <a href="<?=\yii\helpers\Url::toRoute(['/product/order/create'])?>">
        <div class="ordering-button">
            <div>Оформить заказ</div>
        </div>
    </a>
    </br>
    <div class="ordering-tool_tip">
        <img src="<?=$url?>/img/arrow_up.png">
        <div>
            Нажмите сюда когда закончите выбирать
        </div>
    </div>
</div>