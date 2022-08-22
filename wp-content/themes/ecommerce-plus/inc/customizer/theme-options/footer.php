<?php
/**
 * Footer options
 *
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

// Footer Section
$wp_customize->add_section( 'ecommerce_plus_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'ecommerce-plus' ),
		'priority'   			=> 900,
		'panel'      			=> 'ecommerce_plus_theme_options_panel',
	)
);

$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[copyright_text]', array(
	'selector' => '.site-info .container',
) );

// footer text
$wp_customize->add_setting( 'ecommerce_plus_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'type'      			=> 'option',
		'sanitize_callback'		=> 'ecommerce_plus_santize_allowed_html',
	)
);

$wp_customize->add_control( 'ecommerce_plus_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'ecommerce-plus' ),
		'section'    			=> 'ecommerce_plus_section_footer',
		'type'		 			=> 'textarea',
    )
);

// popup cart visible

$wp_customize->add_setting( 'ecommerce_plus_options[popup_cart_visible]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[popup_cart_visible]',
	array(
		'section'   => 'ecommerce_plus_section_footer',
		'label'     => esc_html__( 'Display Popup Cart / My Account', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// scroll top visible

$wp_customize->add_setting( 'ecommerce_plus_options[scroll_top_visible]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[scroll_top_visible]',
	array(
		'section'   => 'ecommerce_plus_section_footer',
		'label'     => esc_html__( 'Display Scroll Top Button', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// background Color
$wp_customize->add_setting( 'ecommerce_plus_options[footer_bg_color]', array(
	'default'           => $options['footer_bg_color'],
	'sanitize_callback' => 'sanitize_hex_color',
	'type'      		=> 'option',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ecommerce_plus_options[footer_bg_color]', array(
	'active_callback' 	=> 'ecommerce_plus_extra_plugin',
	'label'             => __( 'Footer Background Color', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_section_footer',
) ) );


// footer text Color
$wp_customize->add_setting( 'ecommerce_plus_options[footer_text_color]', array(
	'default'           => $options['footer_text_color'],
	'sanitize_callback' => 'sanitize_hex_color',
	'type'      		=> 'option',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ecommerce_plus_options[footer_text_color]', array(
	'label'             => __( 'Footer Text Color', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_section_footer',
) ) );

// image
$wp_customize->add_setting('ecommerce_plus_options[footer_image]', array(
	'default'			=> $ecommerce_plus_options['footer_image'],
	'transport'         => 'refresh',
	'sanitize_callback' => 'esc_url_raw',
	'type'        		=> 'option',
));
	
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ecommerce_plus_options[footer_image]', array(
	'label'             => __('Background Image', 'ecommerce-plus'),
	'section'           => 'ecommerce_plus_section_footer',
	'settings'          => 'ecommerce_plus_options[footer_image]',
)));


// Test of Sample Custom Control
$wp_customize->add_setting( 'ecommerce_plus_options[footer_notice]',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Link_Control( $wp_customize, 'ecommerce_plus_options[footer_notice]',
   array(
      'link' => ECOMMERCE_PLUS_URI,
      'description'  => esc_html__( 'Edit footer custom link and background colors, Go Pro...' , 'ecommerce-plus' ),
      'section' => 'ecommerce_plus_section_footer'
   )
) );
