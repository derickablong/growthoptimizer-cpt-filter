<?php

namespace GO_CPT_Filter;

trait GO_2C_Sidebar_Filter_Article
{
    public function _2c_sidebar_filter_article()
    {
        # 2C Sidebar Filter Article Loop Widget
        include $this->widgets_dir . '/2c-sidebar-filter-article/elementor.php';               

        # 2C Sidebar Filter Article Actions
        $this->actions_2c_sidebar_filter_article();
    }


    /**
     * 2C Sidebar Filter Article Actions
     * @return void
     */
    private function actions_2c_sidebar_filter_article()
    {
        # 2c Photo Article Scripts
        add_action(
            'wp_enqueue_scripts',
            [$this, 'library_2c_sidebar_filter_article']
        );
        # 2C Phto Article Parts Filters
        add_action(
            '2c-sidebar-filter-article-parts-sidebar',
            [$this, 'template_2c_sidebar_filter_article_parts_sidebar'],
            10,
            3
        );
        add_action(
            '2c-sidebar-filter-article-parts-content',
            [$this, 'template_2c_sidebar_filter_article_parts_content'],
            10,
            1
        );                                     
        # Ajax loop
        add_action(
            'wp_ajax_2c_sidebar_filter_article',
            [$this, 'ajax_2c_sidebar_filter_article']
        );
    }


    /**
     * 2C Sidebar Filter Article Library
     * 
     * @return void
     */
    public function library_2c_sidebar_filter_article()
    {
        wp_register_style( 
            'go-cpt-filter-2c-sidebar-filter-article-css', 
            $this->plugin_url . 'assets/css/2c-sidebar-filter-article.css', 
            array(), 
            uniqid(), 
            'all' 
        );
        wp_register_script( 
            'go-cpt-filter-2c-sidebar-filter-article-script', 
            $this->plugin_url . 'assets/js/2c-sidebar-filter-article.js', 
            array( 'jquery' ), 
            uniqid(), 
            true
        );   
        wp_localize_script( 'go-cpt-filter-2c-sidebar-filter-article-script', 'go_kit', array(
            'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
        ) );
    }


    /**
     * 2C Sidebar Filter Article Parts Sidebar
     * 
     * @param array $taxonomies
     * @param array $icons
     * @return void
     */
    public function template_2c_sidebar_filter_article_parts_sidebar($post_type, $taxonomies, $icons)
    {
        include $this->widgets_dir . '2c-sidebar-filter-article/parts/sidebar.php';
    }


    /**
     * 2C Sidebar Filter Article Parts Content
     * 
     * @param string $slug
     * @return void
     */
    public function template_2c_sidebar_filter_article_parts_content($slug)
    {
        $post_type = get_post_type_object( $slug );
        include $this->widgets_dir . '2c-sidebar-filter-article/parts/content.php';
    }


    /**
     * Ajax 2C Sidebar Filter Article
     * @return void
     */
    public function ajax_2c_sidebar_filter_article()
    {
        ob_start();

        # Target CPT
        $post_type  = $_POST['post_type'];
        $taxonomies = $_POST['taxonomies'];
        $loop_item  = $_POST['loop'];
        $keyword    = trim($_POST['keyword']);

        # Filter
        $paged    = $_POST['paged'];
        $per_page = $_POST['per_page'];

        $args = [
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            's'              => $keyword,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ];

        # Category
        if (!empty($taxonomies)) {
            $tax_group = [];
            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy['term_id'] == 'view-all') continue;
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

        $big = 999999999;

        wp_send_json([
            'posts' => ob_get_clean(),
            'data'  => $results,
            'navigation' => paginate_links( array(
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'    => '?paged=%#%',
                'current'   => max( 1, $paged ),
                'total'     => $results->max_num_pages,
                'next_text' => 'Next <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path d="M13.8142 12.071L8.86421 7.12098C8.68205 6.93238 8.58126 6.67978 8.58353 6.41758C8.58581 6.15538 8.69098 5.90457 8.87639 5.71916C9.0618 5.53375 9.31261 5.42859 9.57481 5.42631C9.837 5.42403 10.0896 5.52482 10.2782 5.70698L15.9352 11.364C16.1227 11.5515 16.228 11.8058 16.228 12.071C16.228 12.3361 16.1227 12.5905 15.9352 12.778L10.2782 18.435C10.0896 18.6171 9.837 18.7179 9.57481 18.7157C9.31261 18.7134 9.0618 18.6082 8.87639 18.4228C8.69098 18.2374 8.58581 17.9866 8.58353 17.7244C8.58126 17.4622 8.68205 17.2096 8.86421 17.021L13.8142 12.071Z" fill="#0F62FE"/>
                                    </svg>',
                'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
  <path d="M11.257 12.0002L16.207 16.9502C16.3026 17.0424 16.3787 17.1528 16.4311 17.2748C16.4836 17.3968 16.5111 17.528 16.5123 17.6608C16.5135 17.7936 16.4882 17.9252 16.4379 18.0481C16.3876 18.171 16.3133 18.2827 16.2194 18.3766C16.1256 18.4705 16.0139 18.5447 15.891 18.595C15.7681 18.6453 15.6364 18.6706 15.5036 18.6694C15.3709 18.6683 15.2396 18.6407 15.1176 18.5883C14.9956 18.5359 14.8853 18.4597 14.793 18.3642L9.13605 12.7072C8.94858 12.5197 8.84326 12.2653 8.84326 12.0002C8.84326 11.735 8.94858 11.4807 9.13605 11.2932L14.793 5.63618C14.9817 5.45402 15.2343 5.35323 15.4964 5.35551C15.7586 5.35778 16.0095 5.46295 16.1949 5.64836C16.3803 5.83377 16.4854 6.08458 16.4877 6.34678C16.49 6.60898 16.3892 6.86158 16.207 7.05018L11.257 12.0002Z" fill="#121619"/>
</svg> Previous'
              ))
        ]);
        wp_die();
    }
}