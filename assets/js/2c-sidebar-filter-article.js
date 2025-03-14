(function($) {
    GO_2C_SIDEBAR_FILTER_ARTICLE = {
        doc          : null,
        window       : null,
        pagination   : null,
        active_toggle: null,
        results      : null,
        paged        : 0,
        per_page     : 0,
        post_type    : null,
        loop         : 0,
        search       : null,
        timer        : null,
        keyword      : null,

        _init: function() {
            GO_2C_SIDEBAR_FILTER_ARTICLE._elements(
                GO_2C_SIDEBAR_FILTER_ARTICLE._actions
            );
        },

        _actions: function() {

            // Toggle taxonomy group
            GO_2C_SIDEBAR_FILTER_ARTICLE.doc.on(
                'click',
                '.taxonomy-group .taxonomy-title',
                GO_2C_SIDEBAR_FILTER_ARTICLE._toggle
            );

            // On select term
            GO_2C_SIDEBAR_FILTER_ARTICLE.doc.on(
                'change',
                '.taxonomies input',
                GO_2C_SIDEBAR_FILTER_ARTICLE._term_selected
            );

            // Pagination
            GO_2C_SIDEBAR_FILTER_ARTICLE.doc.on(
                'click',
                '.go-content .navigate a',
                GO_2C_SIDEBAR_FILTER_ARTICLE._navigate
            );

            // Search
            GO_2C_SIDEBAR_FILTER_ARTICLE.search.on(
                'keyup',
                GO_2C_SIDEBAR_FILTER_ARTICLE._start_search
            );
            GO_2C_SIDEBAR_FILTER_ARTICLE.search.on(
                'keydown', function() {
                    clearTimeout(GO_2C_SIDEBAR_FILTER_ARTICLE.timer);
                }
            );

            // Load default
            GO_2C_SIDEBAR_FILTER_ARTICLE._request();

            // Close toggle if mobile
            GO_2C_SIDEBAR_FILTER_ARTICLE.window.on(
                'resize', 
                GO_2C_SIDEBAR_FILTER_ARTICLE._resize
            );
            GO_2C_SIDEBAR_FILTER_ARTICLE.window.trigger('resize');

        },

        _before: function() {
            GO_2C_SIDEBAR_FILTER_ARTICLE.results.addClass('loading');
        },

        _after: function() {
            GO_2C_SIDEBAR_FILTER_ARTICLE.results.removeClass('loading');
        },

        _server: function(data, _callback) {
            GO_2C_SIDEBAR_FILTER_ARTICLE._before();
            $.ajax({
                url     : go_kit.ajaxurl,
                type    : 'POST',
                dataType: 'json',
                data    : data
            }).done(_callback);
        },

        _get_terms: function(_callback) {
            let taxonomies = [];            
            $('.taxonomies input:checked').each(function() {
                
                let taxonomy = $(this).data('term');
                let term_id  = $(this).val();
              
                taxonomies.push({
                    term_id : term_id,
                    taxonomy: taxonomy
                });                
            });                    
            
            _callback(taxonomies);
        },

        _start_search: function() {
            clearTimeout(GO_2C_SIDEBAR_FILTER_ARTICLE.timer);
            GO_2C_SIDEBAR_FILTER_ARTICLE.timer = setTimeout(
                GO_2C_SIDEBAR_FILTER_ARTICLE._search, 500
            );
        },

        _search: function() {
            GO_2C_SIDEBAR_FILTER_ARTICLE.paged   = 1;
            GO_2C_SIDEBAR_FILTER_ARTICLE.keyword = GO_2C_SIDEBAR_FILTER_ARTICLE.search.val();
            GO_2C_SIDEBAR_FILTER_ARTICLE._request();
        },

        _request: function() {
            GO_2C_SIDEBAR_FILTER_ARTICLE._get_terms(function(taxonomies) {
                GO_2C_SIDEBAR_FILTER_ARTICLE._server({
                    action    : '2c_sidebar_filter_article',
                    post_type : GO_2C_SIDEBAR_FILTER_ARTICLE.post_type,
                    paged     : GO_2C_SIDEBAR_FILTER_ARTICLE.paged,
                    per_page  : GO_2C_SIDEBAR_FILTER_ARTICLE.per_page,
                    loop      : GO_2C_SIDEBAR_FILTER_ARTICLE.loop,
                    keyword   : GO_2C_SIDEBAR_FILTER_ARTICLE.keyword,
                    taxonomies: taxonomies,
                }, GO_2C_SIDEBAR_FILTER_ARTICLE._load);
            });
        },

        _load: function(response) {
            console.log(response);
            GO_2C_SIDEBAR_FILTER_ARTICLE.results.html(
                response.posts
            );
            GO_2C_SIDEBAR_FILTER_ARTICLE.pagination.html(
                response.navigation
            );
            GO_2C_SIDEBAR_FILTER_ARTICLE._after();
        },

        _toggle: function(e) {
            e.preventDefault();
            GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle = $(this).parent();                        
            if (!GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle.hasClass('active')) {                
                GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle.addClass('active');
            } else {
                GO_2C_SIDEBAR_FILTER_ARTICLE.active_toggle.removeClass('active');
            }            
        },

        _term_selected: function() {
            const checkbox = $(this);
            const container = checkbox.closest('.terms');
            if (checkbox.val() === 'view-all') {
                if (checkbox.is(':checked')) {                    
                    container.find('.term-checkbox').prop('checked', false);
                }
            } else {
                container.find('.term-view-all').prop('checked', false);
            }
            GO_2C_SIDEBAR_FILTER_ARTICLE.paged = 1;
            GO_2C_SIDEBAR_FILTER_ARTICLE._request();
        },

        _navigate: function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const data = url.split('=');
            GO_2C_SIDEBAR_FILTER_ARTICLE.paged = data[1];
            GO_2C_SIDEBAR_FILTER_ARTICLE._request();
        },

        _resize: function() {
            if (GO_2C_SIDEBAR_FILTER_ARTICLE.window.width() <= 820) {
                $('.taxonomy-group').removeClass('active');
            } else {
                $('.taxonomy-group').addClass('active');
            }
        },

        _elements: function(_callback) {
            GO_2C_SIDEBAR_FILTER_ARTICLE.doc        = $(document);
            GO_2C_SIDEBAR_FILTER_ARTICLE.window     = $(window);
            GO_2C_SIDEBAR_FILTER_ARTICLE.paged      = 1;
            GO_2C_SIDEBAR_FILTER_ARTICLE.post_type  = $('.cpt-2c-sidebar-filter-article').data('post_type');
            GO_2C_SIDEBAR_FILTER_ARTICLE.per_page   = parseInt($('.cpt-2c-sidebar-filter-article').data('per_page'));
            GO_2C_SIDEBAR_FILTER_ARTICLE.loop       = parseInt($('.cpt-2c-sidebar-filter-article').data('loop'));
            GO_2C_SIDEBAR_FILTER_ARTICLE.results    = $('.go-content .results');
            GO_2C_SIDEBAR_FILTER_ARTICLE.pagination = $('.go-content .navigate');
            GO_2C_SIDEBAR_FILTER_ARTICLE.search     = $('.search-widget input');
            _callback();
        }
    }
    GO_2C_SIDEBAR_FILTER_ARTICLE._init();
})(jQuery);