(function($){$(function() {


    $(".table-active-sites, .table-free-sites").sortable({
        connectWith: ".table-sites",
        receive: function(event, ui) {
            var $table = $(this).closest('.table-sites');
            console.log($table);
            if ($table.hasClass('table-free-sites')) {
                $(ui.item).find('input')
                    .attr('name', '')
                    .val('');
            } else {
                $table.find('.site-item').each(function(index, item) {
                    var name = $table.data('field')
                        .replace('_g_', $table.data('gid'))
                        .replace('_sid_', $(item).find('input').data('sid'));
                    $(item).find('input').attr('name', name);
                });
            }
        }
    }).disableSelection();

})})(jQuery);