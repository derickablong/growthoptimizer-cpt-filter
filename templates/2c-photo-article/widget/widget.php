<?php

use ElementorPro\Modules\QueryControl\Module as Module_Query;

class GO_2C_PHOTO_ARTICLE_WIDGET extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve tooltip widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'go_2c_photo_article_loop';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve tooltip widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '2C Photo Article Loop', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve tooltip widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'posts', 'loop', 'cpt', 'article', '2c' ];
	}

	/**
	 * Register tooltip widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() { require ( __DIR__ . '/controls.php' ); }

	/**
	 * Render tooltip widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() { require ( __DIR__ . '/view/render.php' ); }

	/**
	 * Render tooltip widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() { require ( __DIR__ . '/view/editor.php' ); }


    /**
	 * Get Query Name
	 *
	 * Returns the query control name used in the widget's main query.
	 *
	 * @since 3.8.0
	 *
	 * @return string
	 */
	public function get_query_name() {
		return $this->get_name();
	}

    /**
     * Get post type list
     * @return array
     */
    public function get_post_type()
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

}
