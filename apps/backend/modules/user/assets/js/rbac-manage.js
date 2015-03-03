(function($) {$(function() {

    $('.nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    function checkResponce(json)
    {
        if (json.result == 'ok') {
            return true;
        }
        alert(json.message);
        return false;
    }

    function renderOptions(items)
    {
        var html = '';
        $.each(items, function(index, value) {
            html += "<option value=\""+value+"\">"+value+"</option>\n";
        });
        return html;
    }

    $('.manage-block')
        .on('change', '.key-list', function() {
            var $block   = $(this).closest('.manage-block'),
                $assigned = $block.find('.assigned'),
                $available = $block.find('.available'),
                listUrl  = $block.data('list-url'),
                selected = $(this).val()
            ;

            $.getJSON(listUrl, {selected : selected}, function(data) {
                if (!checkResponce(data)) {
                    return;
                }
                data = data.data;

                $assigned.html(renderOptions(data.assigned)).val(-1);
                $available.html(renderOptions(data.notAssigned)).val(-1);
            });
        })
        .on('click', '.assign,.remove', function() {
            var $block     = $(this).closest('.manage-block'),
                $assigned  = $block.find('.assigned'),
                $available = $block.find('.available'),
                avalSelected = $available.val(),
                itemSelected = $block.find('.key-list').val(),
                url          = null,
                subItem      = null
            ;

            if ($(this).hasClass('assign')) {
                url = $block.data('assign-url');
                subItem = $available.val();
            } else {
                url = $block.data('remove-url');
                subItem = $assigned.val();
            }

            if (!subItem || !itemSelected) {
                return;
            }

            $.getJSON(url, {
                subItem : subItem,
                item    : itemSelected
            }, function(data) {
                if (!checkResponce(data)) {
                    return;
                }
                data = data.data;

                $assigned.html(renderOptions(data.assigned)).val(avalSelected);
                $available.html(renderOptions(data.notAssigned)).val(-1);
            });
        })
        .on('focus', '.available', function() {
            $(this).closest('.manage-block').find('.assigned').val(-1);
        })
        .on('focus', '.assigned', function() {
            $(this).closest('.manage-block').find('.available').val(-1);
        });



})})(jQuery);