(function($){$(function() {

    function manageForm(disabled)
    {
        $('.seo-data-widget-backend .form-wrapper')
            .find(':input')
            .prop('disabled', disabled);
    }
    if (!$('.seo-data-widget-backend .enable-seo').prop('checked')) {
        manageForm(true);
    }


    $('.seo-data-widget-backend')
        .on('click', '.title-label', function() {
            var $block = $('.seo-data-widget-backend'),
                $check = $block.find('.enable-seo'),
                enabled = !$check.prop('checked');

            $check.prop('checked', enabled);
            manageForm(!enabled);
        })
        .on('click', '.enable-seo', function() {
            manageForm(!$(this).prop('checked'));
        });

})})(jQuery);