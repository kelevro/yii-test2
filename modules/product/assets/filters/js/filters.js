$('#search-form :checkbox').on('change', function(){
    $(this).closest('form').submit();
});