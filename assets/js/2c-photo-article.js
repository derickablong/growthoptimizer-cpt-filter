(function($) {    
    GO_2C_PHOTO_ARTICLE = {
        doc      : null,
        paged    : 0,
        per_page : 0,
        post_type: null,
        loop     : 0,

        init: function() {
            GO_2C_PHOTO_ARTICLE.set(
                GO_2C_PHOTO_ARTICLE.actions
            );            
        },

        set: function(_callback) {

            GO_2C_PHOTO_ARTICLE.doc       = $(document);
            GO_2C_PHOTO_ARTICLE.paged     = 1;
            GO_2C_PHOTO_ARTICLE.post_type = $('.cpt-2c-photo-article').data('post_type');            
            GO_2C_PHOTO_ARTICLE.per_page  = parseInt($('.cpt-2c-photo-article').data('per_page'));
            GO_2C_PHOTO_ARTICLE.loop      = parseInt($('.cpt-2c-photo-article').data('loop'));
            _callback();
        },

        actions: function() {
            // Display dropdown
            GO_2C_PHOTO_ARTICLE.doc.on('click', '.filter-btn', function(e) {
                e.preventDefault();
                let $btn  = $(this);
                let $item = $btn.parent();
                let $dropdown = $item.find('.dropdown');

                if ($btn.hasClass('active')) {

                    $('.filter-btn').removeClass('active');
                    $('.dropdown').removeClass('active');

                    $dropdown.removeClass('active');
                    $btn.removeClass('active');
                } else {                        

                    $('.filter-btn').removeClass('active');
                    $('.dropdown').removeClass('active');

                    $dropdown.addClass('active');
                    $btn.addClass('active');
                    if ($dropdown.hasClass('date')) {                                
                        $('.input-order-date').focus();
                    }
                }
            });

            // Sort by date
            GO_2C_PHOTO_ARTICLE.doc.on('click', '.dropdown.sort a', function(e) {
                e.preventDefault();
        
                $('.dropdown.sort a').removeClass('selected');
                $(this).addClass('selected');
                
                GO_2C_PHOTO_ARTICLE.paged = 1;
                GO_2C_PHOTO_ARTICLE.request();
        
            });

            // Select checkbox
            GO_2C_PHOTO_ARTICLE.doc.on('click', '.dropdown.categories a', function(e) {
                e.preventDefault();

                let $checkbox = $(this);
                if ($checkbox.hasClass('selected')) {
                    $checkbox.removeClass('selected');
                } else {
                    $checkbox.addClass('selected');
                }

                GO_2C_PHOTO_ARTICLE.paged = 1;
                GO_2C_PHOTO_ARTICLE.request();
            });
            
            // Remove term selected when a term button is clicked
            GO_2C_PHOTO_ARTICLE.doc.on('click', '.term-selected', function(e) {
                e.preventDefault();
                let $term = $(this);
                let _term_id = $term.find('.term_data').data('id');

                // Find the term in the dropdown and deselect it
                $(`.dropdown.categories a.selected[data-term="${_term_id}"]`).removeClass('selected');

                // Now remove the term from the displayed selection
                $term.remove();

                // After removal, you may need to call a function to update the page display, filters, etc.
                // This is an example of what you might do
                GO_2C_PHOTO_ARTICLE.paged = 1;
                GO_2C_PHOTO_ARTICLE.request();
            });

            // Outside element
            GO_2C_PHOTO_ARTICLE.doc.click(function(event) { 
                var $target = $(event.target);
                if(!$target.closest('.filter-item').length && !$target.closest('.daterangepicker').length) {            
                    $('.filter-btn, .dropdown').removeClass('active');
                }
            });

            // Load more
            GO_2C_PHOTO_ARTICLE.doc.on('click', '.load-more a', function(e) {
                e.preventDefault();
                GO_2C_PHOTO_ARTICLE.paged += 1;
                GO_2C_PHOTO_ARTICLE.request();
            });

            // Load default articles
            GO_2C_PHOTO_ARTICLE.request();
        },

        request: function() {
            $('.filter-results, .load-more, .applied-filters').addClass('loading');
            GO_2C_PHOTO_ARTICLE.get_terms(function(taxonomies, order) {                
                $.ajax({
                    url     : go_kit.ajaxurl,
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        action    : '2c_photo_article',
                        post_type : GO_2C_PHOTO_ARTICLE.post_type,                        
                        paged     : GO_2C_PHOTO_ARTICLE.paged,
                        per_page  : GO_2C_PHOTO_ARTICLE.per_page,
                        loop      : GO_2C_PHOTO_ARTICLE.loop,
                        taxonomies: taxonomies,
                        order     : order
                    }
                }).done(function( _response ) {
                    console.log(_response.args);
                    if (parseInt(_response.data.found_posts) >= GO_2C_PHOTO_ARTICLE.per_page) {
                        $('.load-more').css('display', 'flex');
                    } else {
                        $('.load-more').hide();
                    }

                    if (GO_2C_PHOTO_ARTICLE.paged > 1) {
                        $('.filter-results').append(_response.posts);
                    } else {                    
                        $('.filter-results').html(_response.posts);
                    }
                    
                    $('.filter-results, .load-more, .applied-filters').removeClass('loading');
                });

            });
        },

        get_terms: function(_callback) {
            let taxonomies = [];
            let order      = 'DESC';

            // Clear existing selected terms display
            $('.applied-filters').html('');

            // Iterate over selected categories and populate the _terms array
            $('.dropdown.categories a.selected').each(function() {
                let term_data = $(this).data('term');
                let taxonomy  = $(this).data('taxonomy');
                let term_name = $(this).find('span:last-child')[0].innerText;
                taxonomies.push({
                    term_id : term_data,
                    taxonomy: taxonomy
                });

                // Append each as a button to the display
                $('.applied-filters').append(`
                    <div class="elementor-element term-selected button-green elementor-widget elementor-widget-button" data-id="61fa91f" data-element_type="widget" data-widget_type="button.default">
                            <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                    <a class="elementor-button elementor-button-link elementor-size-sm" href="#">
                                        <span class="elementor-button-content-wrapper">
                                            <span class="term_data" data-id="${term_data}">${term_name}</span>
                                            <svg aria-hidden="true" class="e-font-icon-svg e-fas-times" viewBox="0 0 352 512" xmlns="http://www.w3.org/2000/svg"><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                    </div>
                    
                `);
            });         
            
            // Update the order based on the selected sorting order
		    order = $('.dropdown.sort a.selected').data('order');

            // Call the callback function with _terms and order
            _callback(taxonomies, order);
        }
    }
    GO_2C_PHOTO_ARTICLE.init();
})(jQuery)