(function($) {$(function() {
    function recalcSummary() {
        var sum = {};
        $('.serp-groups .form-control').each(function(index, item) {
            var group = $(item).val();
            if (sum[group] == undefined) {
                sum[group] = 0;
            }
            sum[group]++;
        });
        for (var idx in sum) {
            var $group = $('.group-info.group-'+idx);
            var groupDefault = parseInt($group.find('.default-count').text());
            $group.find('.actual-count').text(sum[idx]);

            if (groupDefault != sum[idx]) {
                $group.addClass('has-error');
            } else {
                $group.removeClass('has-error');
            }
        }

    }
    recalcSummary();
    $('.serp-groups').on('change', '.form-control', function() {
        var $tr = $(this).closest('tr'),
            $colors = $('.group-colors'),
            groupId = $colors.find('.color-'+$(this).val()).data('group');

        $tr
            .removeClass('group-'+$tr.data('group'))
            .addClass('group-'+groupId)
            .data('group', groupId);

        recalcSummary();
    });
})})(jQuery);