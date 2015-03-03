(function($){$(function() {

    $('.seo-rules.list')
        .on('click', '.seo-model-add',function() {
            window.location = $(this).attr('href') + '?model='+$('#seo-model-select').val();
            return false;
        });

})})(jQuery);