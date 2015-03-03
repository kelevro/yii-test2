(function($) {$(function() {
    $('.product.list')
        .on('click', '.add-button',function() {
            window.location = $(this).attr('href') + '?category='+$('#product-select-category').val();
            return false;
        });
})})(jQuery);