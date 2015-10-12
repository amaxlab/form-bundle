(function($) {
    $('[data-select-or-add-id]').forEach(function(el){
        $($(el).data('select-or-add-id')).on('click',function(e){
            e.target.toggle();
        });
    });
})(window.jQuery);