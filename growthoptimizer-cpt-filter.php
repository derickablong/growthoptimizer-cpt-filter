<?php
/**
 * Plugin Name:     Growth Optimizer CPT Filter
 * Plugin URI:      https://growthoptimizer.com
 * Description:     Custom filter for CPT
 * Author:          Growth Optimizer
 * Author URI:      https://growthoptimizer.com/
 * Text Domain:     go-kit
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         growthoptimizer-cpt-filter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define('GROWTH_OPTIMIZER_FILTER_DIR', plugin_dir_path( __FILE__ ));
define('GROWTH_OPTIMIZER_FILTER_URL', plugin_dir_url( __FILE__ ));
define('BUTTON_CLASSES', [
    'primary'         => 'Primary',
    'secondary'       => 'Secondary',
    'secondary white' => 'Secondary White',
    'tertiary'        => 'Tertiary'
]);

class GrowthOptimizer_CPT_Filter
{
    
    
    # Plugin directory path
    public $plugin_dir;

    # Plugin directory URL
    public $plugin_url;

    # Template path
    public $widgets_dir;


    /**
     * Starting point
     * @param string $plugin_dir
     * @param string $plugin_url
     */
    function __construct( $plugin_dir, $plugin_url )
    {       

        $this->plugin_dir  = $plugin_dir;
        $this->plugin_url  = $plugin_url;
        $this->widgets_dir = $plugin_dir.'widgets/';

        $this->init();        
    }


    /**
     * Initialize needed components
     * @return void
     */
    private function init()
    {
        # Preview mode
        add_action(
            'go-preview-mode',
            [$this, 'template_preview_mode'],
            10,
            4
        );   
        
        # 2C Photo Article Actions
        $this->actions_2c_photo_article();

        # 2C Sidebar Filter Article Actions
        $this->actions_2c_sidebar_filter_article();
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
            2
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
     * Only display preview mode 
     * if elementor editor is active since
     * jquery will not work on the editor
     * @return void
     */
    public function template_preview_mode()
    {
        include $this->widgets_dir . 'preview.php';
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
     * @return void
     */
    public function template_2c_sidebar_filter_article_parts_content()
    {
        include $this->widgets_dir . '2c-sidebar-filter-article/parts/content.php';
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

        $results = new WP_Query($args);
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
     * Ajax 2C Sidebar Filter Article
     * @return void
     */
    public function ajax_2c_sidebar_filter_article()
    {
        wp_send_json();
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

    
    /**
     * Get template loop items
     * @return array
     */
    public function get_loop_items()
	{
		$loop_items = new WP_Query(array(
            'post_type'      => 'elementor_library',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => [[
                'key'   => '_elementor_template_type',
                'value' => 'loop-item'
            ]]
        ));
        $items = [];
        if ($loop_items->have_posts()): while($loop_items->have_posts()): $loop_items->the_post();
            global $post;            
            $items[$post->ID] = $post->post_title;
        endwhile; endif;
    
        return $items;
	}


    /**
     * Get post type list
     * @return array
     */
    public function get_post_types()
    {
        $list       = [];
        $post_types = get_post_types(
            [
                'public' => true
            ],
            'objects'
        );
        $exclude = [
            'page',
            'attachment',
            'e-floating-buttons',
            'elementor_library'
        ];
        if ($post_types) {
            foreach ($post_types as $type) {
                if (in_array($type->name, $exclude)) continue;
                $list[$type->name] = $type->labels->singular_name;
            }
        }
        return $list;
    }


    /**
     * Get post count
     * 
     * @param string $post_type
     * @param string $taxonomy
     * @param array $count
     */
    public function post_count($post_type, $taxonomy, $count = [])
    {              

        $args = [
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'posts_per_page' => -1
        ];
       

        $results = new WP_Query($args);
        if ($results->have_posts()): 
            while ($results->have_posts()): $results->the_post();
                $terms = get_the_terms(get_the_ID(), $taxonomy);
                foreach ($terms as $term) {
                    $count[$term->term_id] += 1;
                }
            endwhile;         
        endif;
        wp_reset_query();

        return $count;        
    }

}


$go_cpt_filter = new GrowthOptimizer_CPT_Filter(
    GROWTH_OPTIMIZER_FILTER_DIR,
    GROWTH_OPTIMIZER_FILTER_URL
);

# 2C Photo Article Loop widget
include $go_cpt_filter->widgets_dir . '/2c-photo-article/elementor.php';

# 2C Sidebar Filter Article Loop Widget
include $go_cpt_filter->widgets_dir . '/2c-sidebar-filter-article/elementor.php';