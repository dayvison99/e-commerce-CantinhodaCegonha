<?php
/**
 * Breadcrumb options
 *
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

$wp_customize->add_section( 'ecommerce_plus_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','ecommerce-plus' ),
	'description'       => esc_html__( 'Breadcrumb options.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[breadcrumb_show]', array(
	'default'   => $ecommerce_plus_options['breadcrumb_show'],
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[breadcrumb_show]',
	array(
		'section'   => 'ecommerce_plus_breadcrumb',
		'label'     => esc_html__( 'Show Breadcrumb', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[breadcrumb_product_image]', array(
	'default'   => $ecommerce_plus_options['breadcrumb_product_image'],
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[breadcrumb_product_image]',
	array(
		'section'   => 'ecommerce_plus_breadcrumb',
		'label'     => esc_html__( 'Enable WooCommerce Product Image', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

//category
$wp_customize->add_setting( 'ecommerce_plus_options[breadcrumb_category]', array(
	'default'   => $ecommerce_plus_options['breadcrumb_category'],
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[breadcrumb_category]',
	array(
		'section'   => 'ecommerce_plus_breadcrumb',
		'label'     => esc_html__( 'Hide Category', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
	'type'      => 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'ecommerce-plus' ),
	'active_callback' 	=> 'ecommerce_plus_is_breadcrumb_enable',
	'section'          	=> 'ecommerce_plus_breadcrumb',
) );

// image
$wp_customize->add_setting('ecommerce_plus_options[breadcrumb_image]', array(
	'default'			=> $ecommerce_plus_options['breadcrumb_image'],
	'transport'         => 'refresh',
	'sanitize_callback' => 'esc_url_raw',
	'type'        		=> 'option',
));
	
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ecommerce_plus_options[breadcrumb_image]', array(
	'label'             => __('Background Image', 'ecommerce-plus'),
	'section'           => 'ecommerce_plus_breadcrumb',
	'settings'          => 'ecommerce_plus_options[breadcrumb_image]',
)));
