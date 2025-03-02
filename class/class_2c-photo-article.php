<?php

namespace GO_CPT_Filter;

trait GO_2C_Photo_Article
{
    public function _2c_photo_article()
    {
        # 2C Photo Article Loop widget
        include $this->widgets_dir . '/2c-photo-article/elementor.php';

        # 2C Photo Article Actions
        $this->actions_2c_photo_article();
    }


    /**
     * 2C Photo Article Actions
     * @return void
     */
    private function actions_2c_photo_article()
    {
        # 2c Photo Article Scripts
        add_action(
            'wp_enqueue_scripts',
            [$this, 'library_2c_photo_article']
        );
        # 2C Photo Article Parts Filters
        add_action(
            '2c-photo-article-filter-options-template',
            [$this, 'template_2c_photo_article_filter_options'],
            10,
            2
        );                             
        # Shortcode to display article terms
        add_shortcode(
            '2c-photo-article-terms',
            [$this, 'shortcode_2c_photo_article_terms']
        );
        # Ajax loop
        add_action(
            'wp_ajax_2c_photo_article',
            [$this, 'ajax_2c_photo_article']
        );
    }


    /**
     * Library for 2c Photo Article
     * @return void
     */
    public function library_2c_photo_article()
    {
        wp_register_style( 
            'go-cpt-filter-2c-photo-article-css', 
            $this->plugin_url . 'assets/css/2c-photo-article.css', 
            array(), 
            uniqid(), 
            'all' 
        );
        wp_register_script( 
            'go-cpt-filter-2c-photo-article-script', 
            $this->plugin_url . 'assets/js/2c-photo-article.js', 
            array( 'jquery' ), 
            uniqid(), 
            true
        );   
        wp_localize_script( 'go-cpt-filter-2c-photo-article-script', 'go_kit', array(
            'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
        ) );
    }


    /**
     * Template filter options
     * @param array $taxonomies
     * @param string $button_class
     * @return void
     */
    public function template_2c_photo_article_filter_options($taxonomies, $button_class)
    {        
        include $this->widgets_dir . '2c-photo-article/parts/filters.php';
    }


    /**
     * Request handler for 2c photo article request
     * @return void
     */
    public function ajax_2c_photo_article()
    {
        ob_start();

        # Target CPT
        $post_type  = $_POST['post_type'];
        $taxonomies = $_POST['taxonomies'];
        $loop_item  = $_POST['loop'];

        # Filter
        $paged      = $_POST['paged'];
        $per_page   = $_POST['per_page'];        
        $order      = $_POST['order'];

        $args = [
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => isset($order) ? $order : 'DESC'
        ];

        # Category
        if (!empty($taxonomies)) {
            $tax_group = [];
            foreach ($taxonomies as $taxonomy) {
                $tax_group[$taxonomy['taxonomy']][] = $taxonomy['term_id'];
            }
          
            foreach ($tax_group as $taxonomy => $categories) {
                $args['tax_query'][] = [
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $categories,
                    'operator' => 'IN'
                ];
            }
        }

        $results = new \WP_Query($args);
        if ($results->have_posts()): 
            while ($results->have_posts()): $results->the_post();
                echo do_shortcode('[elementor-template id="'. $loop_item .'"]');
            endwhile; 
        else:
            echo '<div class="no-results">No article found.</div>';
        endif;

        wp_send_json([
            'posts'  => ob_get_clean(),
            'filter' => $_POST,
            'args'   => $args,
            'data'   => $results
        ]);
        wp_die();
    }


    /**
     * Shortcode to display 2c photo article terms
     * @param array $atts
     * @return bool|string
     */
    public function shortcode_2c_photo_article_terms($atts)
    {
        $article_term = [];
        $taxonomies     = is_array($atts) && array_key_exists('taxonomy', $atts) ? $atts['taxonomy'] : '';

        if (empty($taxonomies)) return;

        ob_start();

        $taxonomies = explode(',', $taxonomies);
        foreach ($taxonomies as $tax_name) {
            $terms = get_the_terms(get_the_ID(), $tax_name);

            foreach ($terms as $term) {
                $article_term[] = '<span class="cpt-term cpt-term-'. $term->term_id .'">'. $term->name .'</span>';
            }            
        }    
        echo '<div class="cpt-terms">'. implode('', $article_term) .'</div>';    
        return ob_get_clean();
    }
}