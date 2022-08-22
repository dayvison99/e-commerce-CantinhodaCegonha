<?php
$ecommerce_plus_options = ecommerce_plus_get_theme_options();

// Add service section
$wp_customize->add_section( 'ecommerce_plus_home_section', array(
	'title'             => __( 'Home Template Sections','ecommerce-plus' ),
	'description'       => __( 'Show | Hide | Order Home Sections. If this content not displayed, First create a page from home-page-template and set as home page. Then open customizer. Download and Install eCommerce plugin from our theme page for more sections such as testimonial, service etc.', 'ecommerce-plus' ),
	'priority'   		=> 8,
));


// 1
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_1]', array(
	'default'          	=> $ecommerce_plus_options['home_section_1'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_1]', array(
	'label'             => esc_html__( 'Section 1', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );


// 2
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_2]', array(
	'default'          	=> $ecommerce_plus_options['home_section_2'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_2]', array(
	'label'             => esc_html__( 'Section 2', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );


// 3
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_3]', array(
	'default'          	=> $ecommerce_plus_options['home_section_3'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_3]', array(
	'label'             => esc_html__( 'Section 3', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );


//4
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_4]', array(
	'default'          	=> $ecommerce_plus_options['home_section_4'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_4]', array(
	'label'             => esc_html__( 'Section 4', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );


//5
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_5]', array(
	'default'          	=> $ecommerce_plus_options['home_section_5'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_5]', array(
	'label'             => esc_html__( 'Section 5', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );


//6
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_6]', array(
	'default'          	=> $ecommerce_plus_options['home_section_6'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_6]', array(
	'label'             => esc_html__( 'Section 6', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );


//7
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_7]', array(
	'default'          	=> $ecommerce_plus_options['home_section_7'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_7]', array(
	'label'             => esc_html__( 'Section 7', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );



//8
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_8]', array(
	'default'          	=> $ecommerce_plus_options['home_section_8'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_8]', array(
	'label'             => esc_html__( 'Section 8', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );

//9
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_9]', array(
	'default'          	=> $ecommerce_plus_options['home_section_9'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_9]', array(
	'label'             => esc_html__( 'Section 9', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );



//10
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_10]', array(
	'default'          	=> $ecommerce_plus_options['home_section_10'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_10]', array(
	'label'             => esc_html__( 'Section 10', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );




//11
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_11]', array(
	'default'          	=> $ecommerce_plus_options['home_section_11'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_11]', array(
	'label'             => esc_html__( 'Section 11', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );




//12
$wp_customize->add_setting( 'ecommerce_plus_options[home_section_12]', array(
	'default'          	=> $ecommerce_plus_options['home_section_12'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[home_section_12]', array(
	'label'             => esc_html__( 'Section 12', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_home_section',
	'type'				=> 'select',
	'choices'			=> ecommerce_plus_home_sections(),
) );