<?php

# Sidebar
$this->start_controls_section(
    'section_2c_photo_article_sidebar_style',
    [
        'label' => __( 'Sidebar', 'elementor' ),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);	

$this->add_control(
	'sidebar_bg_color',
	[
		'label'     => esc_html__( 'Background', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .go-sidebar' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
    'sidebar_spacing',
    [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__( 'Padding', 'elementor' ),
        'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
        'selectors' => [
            '{{WRAPPER}} .go-sidebar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);



# Tabs
$this->start_controls_tabs( 'sidebar_tabs' );

# Tab title
$this->start_controls_tab(
    'sidebar_tab_title',
    [
        'label' => esc_html__( 'Title', 'elementor' ),
    ]
);

# Tab Content
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'sidebar_title_typography',
        'label'    => 'Typography',
        'selector' => '{{WRAPPER}} .sidebar-title',
    ]
);

$this->add_control(
	'sidebar_title_color',
	[
		'label'     => esc_html__( 'Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .sidebar-title' => 'color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
    'sidebar_title_spacing',
    [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__( ' Margin', 'elementor' ),
        'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
        'selectors' => [
            '{{WRAPPER}} .sidebar-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();



# Tab title
$this->start_controls_tab(
    'sidebar_tab_category',
    [
        'label' => esc_html__( 'Category', 'elementor' ),
    ]
);

# Tab Content
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'category_heading_typography',
        'label'    => 'Heading Typography',
        'selector' => '{{WRAPPER}} .taxonomy-title h6',
    ]
);

$this->add_control(
	'category_heading_color',
	[
		'label'     => esc_html__( 'Heading Color', 'elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .taxonomy-title h6' => 'color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
    'category_heading_spacing',
    [
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'label' => esc_html__( 'Heading Margin', 'elementor' ),
        'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
        'selectors' => [
            '{{WRAPPER}} .taxonomy-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_tab();



# Tab title
$this->start_controls_tab(
    'sidebar_tab_checkbox_label',
    [
        'label' => esc_html__( 'Terms', 'elementor' ),
    ]
);

# Tab Content
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'checkbox_label_typography',
        'label'    => 'Label Typography',
        'selector' => '{{WRAPPER}} .terms .label',
    ]
);

$this->add_control(
	'checkbox_label_color',
	[
		'label' => esc_html__( 'Label Color', 'elementor' ),
		'type' => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .terms .label' => 'color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'checkbox_active_color',
	[
		'label' => esc_html__( 'Checkbox Active Background', 'elementor' ),
		'type' => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .terms input:checked + .checkbox' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
    'checkbox_item_spacing',
    [
        'type'               => \Elementor\Controls_Manager::NUMBER,
        'label'              => esc_html__( 'Space Bottom', 'elementor' ),
        'placeholder'        => esc_html__( '0', 'elementor' ),
        'frontend_available' => true,
        'devices'            => [ 'desktop', 'tablet', 'mobile' ],
        'default'            => 9,
        'tablet_default'     => [
            'size' => 9,
            'unit' => 'px'
        ],
        'mobile_default'     => [
            'size' => 9,
            'unit' => 'px'
        ],
        'selectors'          => [
            '{{WRAPPER}} .taxonomy-group .terms' => 'gap: {{VALUE}}px;',
        ],
    ]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();