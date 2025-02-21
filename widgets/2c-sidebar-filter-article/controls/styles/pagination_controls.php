<?php

# Pagination
$this->start_controls_section(
    'section_2c_photo_article_pagination_style',
    [
        'label' => __( 'Pagination', 'elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);	

$this->add_responsive_control(
    'pagination_spacing',
    [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__( 'Margin', 'elementor' ),
        'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
        'selectors' => [
            '{{WRAPPER}} .go-content .navigate' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'pagination_spacing_divider',
    [
        'type' => \Elementor\Controls_Manager::DIVIDER
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'pagination_typography',        
        'selector' => '{{WRAPPER}} .go-content .navigate a, {{WRAPPER}} .go-content .navigate .page-numbers',
    ]
);




$this->start_controls_tabs( 'pagination_colors' );

$this->start_controls_tab(
    'pagination_colors_normal',
    [
        'label' => esc_html__( 'Normal', 'elementor' ),
    ]
);

$this->add_control(
	'pagination_link_color',
	[
		'label'     => esc_html__( 'Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-content .navigate a' => 'color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'pagination_normal_bg_color',
	[
		'label'     => esc_html__( 'Background Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-content .navigate a.page-numbers:not(.current)' => 'background-color: {{VALUE}};',
		],
	]
);
$this->end_controls_tab();



$this->start_controls_tab(
    'pagination_colors_active',
    [
        'label' => esc_html__( 'Active', 'elementor' ),
    ]
);

$this->add_control(
	'pagination_active_color',
	[
		'label'     => esc_html__( 'Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-content .navigate .current' => 'color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'pagination_active_bg_color',
	[
		'label'     => esc_html__( 'Background Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-content .navigate .current' => 'background-color: {{VALUE}};',
		],
	]
);
$this->end_controls_tab();

$this->end_controls_tabs();



$this->add_control(
    'prev_next_divider',
    [
        'type' => \Elementor\Controls_Manager::DIVIDER
    ]
);

$this->add_control(
	'prev_color',
	[
		'label'     => esc_html__( 'Prev Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-content .navigate .prev' => 'color: {{VALUE}};',
            '{{WRAPPER}} .go-content .navigate .prev path' => 'stroke: {{VALUE}};',
		],
	]
);

$this->add_control(
	'next_color',
	[
		'label'     => esc_html__( 'Next Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-content .navigate .next' => 'color: {{VALUE}};',
            '{{WRAPPER}} .go-content .navigate .next path' => 'stroke: {{VALUE}};',
		],
	]
);


$this->end_controls_section();