//TODO: переписать на прототипах!
function addToCard(context, product_id, count)
{
    var text;
    $.ajax({
        url: '/product/card/add',
        type: 'post',
        data: {product_id: product_id, count: count},
        dataType: 'json',
        beforeSend: function()
        {
            text = $(context).html();
            $(context).html('<img src="/images/ajax-loader-circle.jpg" alt=""/>');
        },
        success: function(data){
            setTimeout(function(){$(context).html(text)}, 100);
            reloadCard(data);
        },
        error: function()
        {
            $(context).html(text);
        }
    });
}

function removeFromCard(product_id)
{
    $.ajax({
        url: '/product/card/remove',
        type: 'post',
        data: {product_id: product_id},
        dataType: 'json',
        success: function(data){
            console.log(data);
            reloadCard(data);
        }
    });
}

function reloadCard($data)
{
    var $container = $('.items-container');

    $container.find('.item').remove();

    if ($data['data']['summaryCount'] > 0) {
        for (var i in $data['data']['products']) {
            $container.append(renderItems($data['data']['products'][i]));
        }
        $('.basket-all-cont').text($data['data']['summaryCount']);
        $('.oder-list-bottom-row-total_summ span').text($data['data']['summaryCost']);
        $('.card-rk-button').removeClass('hide');
        $('.oder-list-bottom-row').removeClass('hide');
        $('.card-empty-msg').addClass('hide');
    } else {
        $container.closest('.cart_more').addClass('hide');
        $('.card-rk-button').addClass('hide');
        $('.oder-list-bottom-row-total_summ span').text(0);
        $('.basket-all-cont').text(0);
        $('.card-empty-msg').removeClass('hide');
        $('.oder-list-bottom-row').addClass('hide');
    }
}

function renderItems($product)
{
    return   '<div class="oder-list-item-conteiner item">'
           + '<div class="oder-list-item-button_close del-from-card" data-product_id="' + $product['id'] + '" title="Удалить товар из корзины">X</div>'
           + '<div class="clear" style="height: 10px;"></div>'
           + '<img src="' + $product['img'] + '" alt=""/>'
           + '<div>' + $product['title'] + '</div>'
           + '<div>$&nbsp;' + $product['price'] +'</div>'
           + '<div>' +$product['count'] +' (шт)</div>'
           + '<div class="clear"></div></div>';
}

