<?php
/**
 * Slider Section options
 */
$ecommerce_plus_options = ecommerce_plus_get_theme_options();

// Add Slider section
$wp_customize->add_section( 'ecommerce_plus_showcase_section', array(
	'title'             => esc_html__( 'Product Showcase','ecommerce-plus' ),
	'description'       => esc_html__( 'Product showcase. If this content not displayed, First create a page from home-page-template and set as home page. Then open customizer.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_home_panel',
));

		
$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[prod_slider_cat_label]', array(
	'selector' => '#home-product-showcase .navigation-name',
) );
		
$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[prod_slider_cat]', array(
	'selector' => '#home-product-showcase .carousel-caption',
) );


// Slider content enable control and setting
$wp_customize->add_setting( 'ecommerce_plus_options[prod_navigation_section_enable]', array(
	'default'   		=> $ecommerce_plus_options['prod_navigation_section_enable'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
	'type'      		=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[prod_navigation_section_enable]', array(
	'section'   => 'ecommerce_plus_showcase_section',
	'label'     => esc_html__( 'Show Product Category Menu', 'ecommerce-plus' ),
	'type'      => 'checkbox'
));

// category label
$wp_customize->add_setting( 'ecommerce_plus_options[prod_slider_cat_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'type' 				=> 'option',
	'default'			=> $ecommerce_plus_options['prod_slider_cat_label'],
));

$wp_customize->add_control( 'ecommerce_plus_options[prod_slider_cat_label]', array(
	'label'           	=> esc_html__( 'Product Category Title', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_showcase_section',
	'type'				=> 'text',
));


// Post Category
$wp_customize->add_setting( 'ecommerce_plus_options[prod_slider_cat]' , array(
	'default'   		=> $ecommerce_plus_options['prod_slider_cat'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'				=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[prod_slider_cat]' , array(
	'label' 	=> __('Select Product Category','ecommerce-plus' ),
	'section' 	=> 'ecommerce_plus_showcase_section',
	'type'		=> 'select',
	'choices'	=> ecommerce_plus_get_product_categories(),
));

// Slider btn label
$wp_customize->add_setting( 'ecommerce_plus_options[prod_slider_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'type' 				=> 'option',
	'default'			=> $ecommerce_plus_options['prod_slider_btn_label'],
));

$wp_customize->add_control( 'ecommerce_plus_options[prod_slider_btn_label]', array(
	'label'           	=> esc_html__( 'Button Label', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_showcase_section',
	'type'				=> 'text',
));

//url
$wp_customize->add_setting( 'ecommerce_plus_options[prod_slider_btn_url]', array(
	'sanitize_callback' => 'esc_url_raw',
	'type' 				=> 'option',
	'default'			=> $ecommerce_plus_options['prod_slider_btn_url'],
));

$wp_customize->add_control( 'ecommerce_plus_options[prod_slider_btn_url]', array(
	'label'           	=> esc_html__( 'Button Link', 'ecommerce-plus' ),
	'description'       => esc_html__( '(If empty, the post link will be used)', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_showcase_section',
	'type'				=> 'text',
));


// Height
$wp_customize->add_setting( 'ecommerce_plus_options[prod_slider_height]', array(
	'default'   		=> $ecommerce_plus_options['prod_slider_height'],
	'sanitize_callback' => 'absint',
	'type'      		=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[prod_slider_height]', array(
	'section'   => 'ecommerce_plus_showcase_section',
	'label'     =>  esc_html__( 'Slider Height (px)', 'ecommerce-plus' ),
	'type'      => 'number'
));


// Max Slides
$wp_customize->add_setting( 'ecommerce_plus_options[prod_slider_max]', array(
	'default'   		=> $ecommerce_plus_options['prod_slider_max'],
	'sanitize_callback' => 'absint',
	'type'      		=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[prod_slider_max]', array(
	'section'   => 'ecommerce_plus_showcase_section',
	'label'     =>  esc_html__( 'Number of Slides', 'ecommerce-plus' ),
	'type'      => 'number'
));

