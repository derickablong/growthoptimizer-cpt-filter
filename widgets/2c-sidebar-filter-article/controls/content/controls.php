<?php

// use \Elementor\Core\Schemes;
global $go_cpt_filter;

$post_types = $go_cpt_filter->get_post_types();
$loop_items = $go_cpt_filter->get_loop_items();

$this->start_controls_section(
    'section_2c_photo_article_post_type',
    [
        'label' => __( 'Filter Settings', 'elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
    ]
);


# Control Post Type
$this->add_control(
    'post_type',
    [
        'label'   => __( 'Post Type', 'elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => $post_types,
        'default' => 'post',
    ]
);

$this->add_control(
    'post_type_divider',
    [
        'type' => \Elementor\Controls_Manager::DIVIDER
    ]
);

# Control Taxonomies
foreach ($post_types as $type => $name) {
    $taxonomies = get_object_taxonomies($type, 'objects');
    foreach ($taxonomies as $taxonomy_slug => $taxonomy) {
        if (in_array($taxonomy_slug, ['post_tag','post_format'])) continue;

        # Taxonomy
        $this->add_control(
            'taxonomy_'.$taxonomy_slug,
            [
                'label'        => esc_html__( $taxonomy->label, 'elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elementor' ),
                'label_off'    => esc_html__( 'No', 'elementor' ),
                'return_value' => $taxonomy->label,
                'default'      => 'no',
                'condition'    => [
                    'post_type' => $type
                ]
            ]
        );

        # Icon
        $this->add_control(
			'tax_icon_'.$taxonomy_slug,
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],				
                'condition'    => [
                    'post_type' => $type,
                    'taxonomy_'.$taxonomy_slug => $taxonomy->label
                ]
			]
		);

        $this->add_control(
            'tax_icon_'.$taxonomy_slug.'_devider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'condition'    => [
                    'post_type' => $type,
                    'taxonomy_'.$taxonomy_slug => $taxonomy->label
                ]
            ]
        );
    }
}

# Control Posts per page
$this->add_control(
    'posts_per_page',
    [
        'label'       => esc_html__( 'Posts per page', 'elementor' ),
        'type'        => \Elementor\Controls_Manager::NUMBER,
        'default'     => 5,
        'placeholder' => esc_html__( '0', 'elementor' ),
    ]
);


# Control columns
$this->add_responsive_control(
    'grid_columns',
    [
        'type'               => \Elementor\Controls_Manager::NUMBER,
        'label'              => esc_html__( 'Columns', 'elementor' ),
        'placeholder'        => esc_html__( '0', 'elementor' ),
        'frontend_available' => true,
        'devices'            => [ 'desktop', 'tablet', 'mobile' ],
        'default'            => 1,
        'tablet_default'     => 1,
        'mobile_default'     => 1,
        'selectors'          => [
            '{{WRAPPER}} .go-content .results' => 'grid-template-columns: repeat({{SIZE}},1fr);',
        ],
    ]
);

$this->add_control(
    'loop_template_divider',
    [
        'type' => \Elementor\Controls_Manager::DIVIDER
    ]
);

# Control Loop Template
$this->add_control(
    'loop_template',
    [
        'label'   => __( 'Loop Template', 'elementor' ),
        'type'    => \Elementor\Controls_Manager::SELECT,
        'options' => $loop_items,
        'default' => '',
    ]
);

$this->end_controls_section();