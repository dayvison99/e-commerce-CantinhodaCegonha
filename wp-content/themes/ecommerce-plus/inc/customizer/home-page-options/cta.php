<?php
$ecommerce_plus_options = ecommerce_plus_get_theme_options();

// Add service section
$wp_customize->add_section( 'ecommerce_plus_cta_section', array(
	'title'             => __( 'Call to Action','ecommerce-plus' ),
	'description'       => __( 'If this section not appears, First create a page from home-page-template and set as home page. Then open customizer.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_home_panel',
));


$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[cta_page]', array(
	'selector' => '#home-cta-section .btn',
) );

// about pages drop down chooser control and setting
$wp_customize->add_setting( 'ecommerce_plus_options[cta_page]', array(
	'default'			=> $ecommerce_plus_options['cta_page'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
));

$wp_customize->add_control( 'ecommerce_plus_options[cta_page]', array(
	'label'     => __( 'Select Page', 'ecommerce-plus' ),
	'section'   => 'ecommerce_plus_cta_section',
	'type'		=> 'select',
	'choices'	=> ecommerce_plus_get_page_choices(),
) );

// cta text
$wp_customize->add_setting( 'ecommerce_plus_options[cta_text]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $ecommerce_plus_options['cta_text'],
	'type'      		=> 'option',
	'transport'			=> 'postMessage',
));

$wp_customize->add_control( 'ecommerce_plus_options[cta_text]', array(
	'label'           	=> __( 'Call to Action Text', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_cta_section',
	'type'				=> 'text',
));


// Text Color
$wp_customize->add_setting( 'ecommerce_plus_options[cta_color]', array(
	'default'           => $options['cta_color'],
	'sanitize_callback' => 'sanitize_hex_color',
	'type'      		=> 'option',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ecommerce_plus_options[cta_color]', array(
	'label'             => __( 'Text Color', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_cta_section',
) ) );

// About btn title setting and control
$wp_customize->add_setting( 'ecommerce_plus_options[cta_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $ecommerce_plus_options['cta_label'],
	'type'      		=> 'option',
));

$wp_customize->add_control( 'ecommerce_plus_options[cta_label]', array(
	'label'           	=> __( 'Button Label', 'ecommerce-plus' ),
	'description'       => __( '(Keep empty to hide the button)', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_cta_section',
	'type'				=> 'text',
));

// cta link
$wp_customize->add_setting( 'ecommerce_plus_options[cta_link]', array(
	'sanitize_callback' => 'esc_url_raw',
	'default'			=> $ecommerce_plus_options['cta_link'],
	'type'      		=> 'option',
));

$wp_customize->add_control( 'ecommerce_plus_options[cta_link]', array(
	'label'           	=> __( 'Link', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_cta_section',
	'type'				=> 'text',
));


// cta image
$wp_customize->add_setting('ecommerce_plus_options[cta_image]', array(
	'default'			=> $ecommerce_plus_options['cta_image'],
	'transport'         => 'refresh',
	'sanitize_callback' => 'esc_url_raw',
	'type'        		=> 'option',
));
	
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ecommerce_plus_options[cta_image]', array(
	'label'             => __('Background Image', 'ecommerce-plus'),
	'section'           => 'ecommerce_plus_cta_section',
	'settings'          => 'ecommerce_plus_options[cta_image]',
)));


// cta height
$wp_customize->add_setting( 'ecommerce_plus_options[cta_height]', array(
	'sanitize_callback' => 'absint',
	'default'			=> $ecommerce_plus_options['cta_height'],
	'type'      		=> 'option',
));

$wp_customize->add_control( 'ecommerce_plus_options[cta_height]', array(
	'label'           	=> __( 'Height', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_cta_section',
	'type'				=> 'number',
));


// Notice
$wp_customize->add_setting( 'ecommerce_plus_options[cta_notice]',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Link_Control( $wp_customize, 'ecommerce_plus_options[cta_notice]',
   array(
      'link' => ECOMMERCE_PLUS_URI,
      'description'  => esc_html__( 'Add call to action text instead of selecting pages, Go Pro...' , 'ecommerce-plus' ),
      'section' => 'ecommerce_plus_cta_section'
   )
) );