<?php

# Content BG
$this->start_controls_section(
    'section_2c_photo_article_content_style',
    [
        'label' => __( 'Content', 'elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);	

$this->add_control(
	'content_bg_color',
	[
		'label' => esc_html__( 'Background', 'elementor' ),
		'type' => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-content' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
    'content_spacing',
    [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__( 'Padding', 'elementor' ),
        'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
        'selectors' => [
            '{{WRAPPER}} .go-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);




# Tabs
$this->start_controls_tabs( 'content_tabs' );

# Tab results
$this->start_controls_tab(
    'content_tab_results',
    [
        'label' => esc_html__( 'Results', 'elementor' ),
    ]
);

# Control column gap
$this->add_responsive_control(
    'column_gap',
    [
        'type'               => \Elementor\Controls_Manager::NUMBER,
        'label'              => esc_html__( 'Column Gap', 'elementor' ),
        'placeholder'        => esc_html__( '0', 'elementor' ),
        'frontend_available' => true,
        'devices'            => [ 'desktop', 'tablet', 'mobile' ],
        'default'            => 30,
        'tablet_default'     => [
            'size' => 30,
            'unit' => 'px'
        ],
        'mobile_default'     => [
            'size' => 30,
            'unit' => 'px'
        ],
        'selectors'          => [
            '{{WRAPPER}} .go-content .results' => 'column-gap: {{VALUE}}px;',
        ],
    ]
);

# Control row gap
$this->add_responsive_control(
    'row_gap',
    [
        'type'               => \Elementor\Controls_Manager::NUMBER,
        'label'              => esc_html__( 'Row Gap', 'elementor' ),
        'placeholder'        => esc_html__( '0', 'elementor' ),
        'frontend_available' => true,
        'devices'            => [ 'desktop', 'tablet', 'mobile' ],
        'default'            => 30,
        'tablet_default'     => 30,
        'mobile_default'     => 30,
        'selectors'          => [
            '{{WRAPPER}} .go-content .results' => 'row-gap: {{VALUE}}px;',
        ],
    ]
);
$this->end_controls_tab();



# Tab search widget
$this->start_controls_tab(
    'content_tab_search',
    [
        'label' => esc_html__( 'Search', 'elementor' ),
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'search_typography',
        'label'    => 'Input Typography',
        'selector' => '{{WRAPPER}} .search-widget input, {{WRAPPER}} .search-widget ::placeholder',
    ]
);

$this->add_control(
	'search_bg_color',
	[
		'label'     => esc_html__( 'Background', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .search-widget' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'search_border',
        'selector' => '{{WRAPPER}} .search-widget',
    ]
);

$this->add_responsive_control(
    'search_border_radius',
    [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__( 'Border Radius', 'elementor' ),
        'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
        'selectors' => [
            '{{WRAPPER}} .search-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'search_spacing',
    [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__( 'Margin', 'elementor' ),
        'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
        'selectors' => [
            '{{WRAPPER}} .search-widget' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);
$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();