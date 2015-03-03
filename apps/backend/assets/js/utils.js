(function($) {$(function() {

    $('.generate-slug').click(function() {
        var title = '#'+$(this).data('title-field'),
            slug  = '#'+$(this).data('slug-field');

        $.getJSON($(this).data('url'), {
            title : $(title).val(),
            max   : $(this).data('max-length')
        }, function(resp) {
            $(slug).val(resp.data.slug);
        });

        return false;
    });

})})(jQuery);