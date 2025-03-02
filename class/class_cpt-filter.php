<?php

namespace GO_CPT_Filter;

class GO_CPT_Filter
{    
    use GO_2C_Photo_Article, GO_2C_Sidebar_Filter_Article;
    
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

        $this->start();        
    }


    /**
     * Start the system
     * @return void
     */
    private function start()
    {
        # Preview mode
        add_action(
            'go-preview-mode',
            [$this, 'template_preview_mode'],
            10,
            4
        );   

        # 2C Photo Article
        $this->_2c_photo_article();

        # 2C Sidebar Filter Article
        $this->_2c_sidebar_filter_article();
        
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
     * Get template loop items
     * @return array
     */
    public function get_loop_items()
	{
		$loop_items = new \WP_Query(array(
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
       
        $loaded      = [];
        $total_posts = 0;
        $results     = new \WP_Query($args);

        if ($results->have_posts()): 
            while ($results->have_posts()): $results->the_post();
                global $post;
                $terms = get_the_terms($post->ID, $taxonomy);
                foreach ($terms as $term) {
                    if (!in_array($post->ID, $loaded)) {
                        $loaded[] = $post->ID;
                        $total_posts += 1;
                    }
                    $count[$term->term_id] += 1;
                }
            endwhile;         
        endif;
        wp_reset_query();

        return [
            'count' => $count,
            'posts' => $total_posts
        ];        
    }

}