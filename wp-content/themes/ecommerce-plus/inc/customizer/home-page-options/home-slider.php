<?php
/**
 * Slider Section options
 */
$ecommerce_plus_options = ecommerce_plus_get_theme_options();

// Add Slider section
$wp_customize->add_section( 'ecommerce_plus_slider_section', array(
	'title'             => esc_html__( 'Main Slider','ecommerce-plus' ),
	'description'       => esc_html__( 'Slider Section options. Select post category, height, button text and a link. If this content not displayed, First create a page from home-page-template and set as home page. Then open customizer.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_home_panel',
));

$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[slider_cat]', array(
	'selector' => '#home-post-slider .carousel-caption',
) );
	

// Post Category
$wp_customize->add_setting( 'ecommerce_plus_options[slider_cat]' , array(
	'default'   		=> $ecommerce_plus_options['slider_cat'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'				=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[slider_cat]' , array(
	'label' 	=> __('Select Post Category [Post featured image is slider image]','ecommerce-plus' ),
	'section' 	=> 'ecommerce_plus_slider_section',
	'type'		=> 'select',
	'choices'	=> ecommerce_plus_get_post_categories(),
));

// Slider btn label
$wp_customize->add_setting( 'ecommerce_plus_options[slider_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'type' 				=> 'option',
	'default'			=> $ecommerce_plus_options['slider_btn_label'],
));

$wp_customize->add_control( 'ecommerce_plus_options[slider_btn_label]', array(
	'label'           	=> esc_html__( 'Button Label', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_slider_section',
	'type'				=> 'text',
));

//url
$wp_customize->add_setting( 'ecommerce_plus_options[slider_btn_url]', array(
	'sanitize_callback' => 'esc_url_raw',
	'type' 				=> 'option',
	'default'			=> $ecommerce_plus_options['slider_btn_url'],
));

$wp_customize->add_control( 'ecommerce_plus_options[slider_btn_url]', array(
	'label'           	=> esc_html__( 'Button Link', 'ecommerce-plus' ),
	'description'       => esc_html__( '(If empty, the post link will be used)', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_slider_section',
	'type'				=> 'text',
));


//button
$wp_customize->add_setting( 'ecommerce_plus_options[slider_button]', array(
	'default'   => $ecommerce_plus_options['slider_button'] ,
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
	'type'      => 'option'
 ) );

$wp_customize->add_control('ecommerce_plus_options[slider_button]',
	array(
		'section'   => 'ecommerce_plus_slider_section',
		'label'     => esc_html__( 'Hide Slider Button', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

//
$wp_customize->add_setting( 'ecommerce_plus_options[title_text]', array(
	'default'   => $ecommerce_plus_options['title_text'] ,
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
	'type'      => 'option'
 ) );

$wp_customize->add_control('ecommerce_plus_options[title_text]',
	array(
		'section'   => 'ecommerce_plus_slider_section',
		'label'     => esc_html__( 'Hide Slider Title', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);


// Height
$wp_customize->add_setting( 'ecommerce_plus_options[slider_height]', array(
	'default'   		=> $ecommerce_plus_options['slider_height'],
	'sanitize_callback' => 'absint',
	'type'      		=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[slider_height]', array(
	'section'   => 'ecommerce_plus_slider_section',
	'label'     =>  esc_html__( 'Slider Height (px)', 'ecommerce-plus' ),
	'type'      => 'number'
));


// Max Slides
$wp_customize->add_setting( 'ecommerce_plus_options[slider_max]', array(
	'default'   		=> $ecommerce_plus_options['slider_max'],
	'sanitize_callback' => 'absint',
	'type'      		=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[slider_max]', array(
	'section'   => 'ecommerce_plus_slider_section',
	'label'     =>  esc_html__( 'Number of Slides', 'ecommerce-plus' ),
	'active_callback' 	=> 'ecommerce_plus_extra_plugin',
	'type'      => 'number'
));


// Notice
$wp_customize->add_setting( 'ecommerce_plus_options[slides_notice]',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Link_Control( $wp_customize, 'ecommerce_plus_options[slides_notice]',
   array(
      'link' => ECOMMERCE_PLUS_URI,
      'description'  => esc_html__( 'Unlimited slides and more slider options, Go Pro...', 'ecommerce-plus' ),
      'section' => 'ecommerce_plus_slider_section'
   )
) );