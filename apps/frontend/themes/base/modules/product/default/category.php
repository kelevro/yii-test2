<?
use frontend\themes\base\assets\BaseAsset;
use product\widgets\Filters;
use yii\helpers\Url;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var product\search\UserSearch $us */
/** @var product\models\Product $product */
/** @var array $allAttrs */
/** @var \product\models\Category $category */
/** @var \yii\web\View $this */

$this->registerJs(<<<JS
$('.increment').on('click', function(){
    var productBlock = $(this).closest('.itemconteiner');
    var resultBlock = $(this).closest('.counter-container').find('.count-result input');
    var count = parseInt(resultBlock.val());
    var price = parseInt(productBlock.find('.item-price-description .price').text());
    count++;
    if (isNaN(count)) {
        return false;
    }
    resultBlock.val(count);
    productBlock.find('.add_to_cart').data('count', count);
    productBlock.find('.item-amount-total span').text(count * price);

});

$('.decrement').on('click', function(){
    var productBlock = $(this).closest('.itemconteiner');
    var resultBlock = $(this).closest('.counter-container').find('.count-result input');
    var count = parseInt(resultBlock.val());
    var price = parseInt(productBlock.find('.item-price-description .price').text());
    count--;
    if (isNaN(count)) {
        return false;
    }
    resultBlock.val(count);
    productBlock.find('.add_to_cart').data('count', count);
    productBlock.find('.item-amount-total span').text(count * price);
});

$('.iten-amount-number input').on('change', function(){
    var productBlock = $(this).closest('.itemconteiner');
    var count = parseInt($(this).val());
    var price = parseInt(productBlock.find('.item-price-description .price').text());
    if (isNaN(count)) {
        return false;
    }
    productBlock.find('.add_to_cart').data('count', count);
    productBlock.find('.item-amount-total span').text(count * price);
});


$('.data-gallery').on('click', function(e){
    var links = $(this).closest('.itemconteiner').find('.links a').get();
    console.log(links);
    blueimp.Gallery(links, {
        container: '#blueimp-gallery'
    });
});

$(".itembuttonsite").on('click', function(e){
    $(this).closest('.doc-container').find('.doc_item-conteiner-product').toggleClass('hide');
});

JS
);

$url = BaseAsset::register($this)->baseUrl;
$models = $dataProvider->getModels();
?>
<?if($dataProvider->pagination->pageCount > 1):?>
    <div class="product-nav-conteiner" style="margin-bottom: 0px">
        <?=\yii\widgets\LinkPager::widget([
            'pagination'        => $dataProvider->pagination,
            'nextPageLabel'     => '',
            'prevPageLabel'     => '',
            'options'           => [],
            'prevPageCssClass'  => 'prev1',
            'nextPageCssClass'  => 'next1',
        ])?>
    </div>
<?endif?>

<div style="width: 1000px;">
    <div class="left-column">
        <?=Filters::widget([
            'category'  => $category,
            'us'        => $us,
        ])?>
    </div>
    <div class="right-column category-block">
        <?foreach($models as $product):?>
            <?$productAttrs = \yii\helpers\ArrayHelper::map($product->attrs, 'attribute_id', 'value')?>

            <div id="product_<?=$product->id?>" class="itemconteiner">
                <div class="main-image">
                    <?if($image = $product->getMainPhoto()):?>
                        <img src="<?=$image->getUrlBySize()?>"
                             alt="<?=$image->alt?>" title="<?=$image->title?>" class="data-gallery">
                        <div class="links hide">
                            <?foreach($product->images as $pImage):?>
                                <a href="<?=$pImage->getUrlBySize('medium')?>"
                                   title="<?=$pImage->title?>">
                                    <img src="<?=$pImage->getUrlBySize('xsmall')?>">
                                </a>
                            <?endforeach?>
                        </div>
                    <?else:?>
                        <img src="http://placehold.it/214x170" alt="" />
                    <?endif?>
                </div>
                <div class="product-info">
                    <h3><?=$product->title?></h3>
                    <div class="decription">
                        <?=\yii\helpers\Html::encode($product->description)?>
                    </div>
                    <?foreach($product->productAttributes as $attr):?>
                        <?if(!isset($productAttrs[$attr->id])):?>
                            <?continue?>
                        <?endif?>
                        <?if($attr->is_selectable && empty($attr->values[$productAttrs[$attr->id]])):?>
                            <?continue?>
                        <?endif?>
                        <?if(!$attr->is_selectable && empty($productAttrs[$attr->id])):?>
                            <?continue?>
                        <?endif?>
                        <div>
                            <span class="item-charecteristic">
                                <?=$attr->title?>
                            </span>
                            <span class="item-description">
                                <?if($attr->is_selectable):?>
                                    <?=$attr->values[$productAttrs[$attr->id]]?>
                                <?else:?>
                                    <?=$productAttrs[$attr->id]?>
                                <?endif?>
                            </span>
                        </div>
                    <?endforeach?>

                    <div>
                    <span class="item-price">
                        ЦЕНА:
                    </span>
                    <span class="item-price-description">
                         $&nbsp;<span class="price"><?=$product->price?></span>
                    </span>
                    </div>
                </div>

                <?if($product->relatedProducts):?>
                <div style="clear: both; width: 100%; height: 15px; margin-bottom: 15px; border-bottom: 1px solid #f5f4f4;"></div>
                <div class="related-products">
                    <div>Сопутствующие товары:</div>
                    <?foreach($product->relatedProducts as $rProduct):?>
                        <div class="item">
                            <a href="<?=Url::toRoute([
                                '/product/default/category',
                                'category' => $rProduct->category_id,
                                'pid' => $rProduct->id,
                                '#' => "product_{$rProduct->id}"
                            ])?>">
                                <?if($rpImage = $rProduct->getMainPhoto()):?>
                                    <img src="<?=$rpImage->getUrlBySize('xsmall')?>"
                                         alt="<?=$rpImage->alt?>" title="<?=$rpImage->title?>">
                                <?else:?>
                                    <img src="http://placehold.it/80x80" alt="" />
                                <?endif?>
                                <div class="title"><?=$rProduct->title?></div>
                            </a>
                        </div>
                    <?endforeach?>
                </div>
                <?endif?>

                <div style="clear: both; width: 100%; height: 15px; margin-bottom: 15px; border-bottom: 1px solid #f5f4f4;"></div>
                <a href="">
                    <div class="itembuttonby add_to_cart"
                         data-product_id="<?=$product->id?>"
                         data-count="1">
                        КУПИТЬ
                    </div>
                </a>
                <div class="item-amount-total">Итого: <span><?=$product->price?></span></div>
                <div class="item-amount-conteiner counter-container">
                    <span class="item-amount-minus decrement">-</span>
                    <span class="iten-amount-number count-result"><input type="text" value="1"/></span>
                    <span class="item-amount-plus increment">+</span>
                </div>
                <div class="doc-container">
                    <?$docs = $product->findRelatedDocumentations()?>
                    <div class="itembuttonsite">Документация (<?=(count($docs))?>)</div>
                    <div class="clear"></div>
                    <div class="doc_item-conteiner-product hide">
                        <?if($docs):?>
                            <?foreach($docs as $doc):?>
                                <a href="<?=\common\helpers\Storage::getStorageUrlTo('documentation') . '/' . $doc->link?>"
                                   target="_blank" class="doc_item-name">
                                    <?=($doc->title)?$doc->title:$doc->link?>
                                </a>
                            <?endforeach?>
                        <?endif?>
                    </div>
                </div>
            </div>
        <?endforeach?>
    </div>
</div>

    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>

<?if($dataProvider->pagination->pageCount > 1):?>
    <div class="clear"></div>
    <div class="product-nav-conteiner">
        <?=\yii\widgets\LinkPager::widget([
            'pagination'        => $dataProvider->pagination,
            'nextPageLabel'     => '',
            'prevPageLabel'     => '',
            'options'           => [],
            'prevPageCssClass'  => 'prev1',
            'nextPageCssClass'  => 'next1',
        ])?>
    </div>
<?endif?>