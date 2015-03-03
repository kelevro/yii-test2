(function($) {$(function() {
    $('#select-multisite').change(function() {
        window.location = '/site/set-multisite?name='+$(this).val();
    });
})})(jQuery);