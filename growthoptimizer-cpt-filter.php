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
    protected $plugin_dir;

    # Plugin directory URL
    protected $plugin_url;

    # Template path
    protected $template_dir;


    /**
     * Starting point
     * @param string $plugin_dir
     * @param string $plugin_url
     */
    function __construct( $plugin_dir, $plugin_url )
    {
        $this->plugin_dir = $plugin_dir;
        $this->plugin_url = $plugin_url;
        $this->template_dir = $plugin_dir.'templates/';

        $this->init();
    }


    /**
     * Initialize needed components
     * @return void
     */
    private function init()
    {
        # 2c Photo Article Scripts
        add_action(
            'wp_enqueue_scripts',
            [$this, 'library_2c_photo_article']
        );
        # Template filter options
        add_action(
            '2c-photo-article-filter-options-template',
            [$this, 'template_2c_photo_article_filter_options'],
            10,
            2
        );                
        # Preview mode
        add_action(
            'go-preview-mode',
            [$this, 'template_preview_mode'],
            10,
            4
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

        # Create widget
        include $this->plugin_dir . '/templates/2c-photo-article/widget/create.php';
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
        include $this->template_dir . '2c-photo-article/filter-options.php';
    }


    /**
     * Only display preview mode 
     * if elementor editor is active since
     * jquery will not work on the editor
     * @return void
     */
    public function template_preview_mode()
    {
        include $this->template_dir . '2c-photo-article/preview.php';
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
new GrowthOptimizer_CPT_Filter(
    GROWTH_OPTIMIZER_FILTER_DIR,
    GROWTH_OPTIMIZER_FILTER_URL
);