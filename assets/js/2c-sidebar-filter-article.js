(function($) {
    GO_2C_SIDEBAR_FILTER_ARTICLE = {
        doc          : $(document),
        active_toggle: null,

        init: function() {
            GO_2C_SIDEBAR_FILTER_ARTICLE.actions();
        },

        actions: function() {

            // Toggle taxonomy group
            GO_2C_SIDEBAR_FILTER_ARTICLE.doc.on(
                'click',
                '.taxonomy-group .taxonomy-title',
                GO_2C_SIDEBAR_FILTER_ARTICLE._toggle
            );

        },

        _toggle: function(e) {
            e.preventDefault();
            GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle = $(this).parent();                        
            if (!GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle.hasClass('active')) {                
                GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle.addClass('active');
            } else {
                GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle.removeClass('active');
            }
            
        }
    }
    GO_2C_SIDEBAR_FILTER_ARTICLE.init();
})(jQuery);