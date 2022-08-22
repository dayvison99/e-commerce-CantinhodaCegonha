<?php
/**
 * pagination options
 *
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

// Add sidebar section
$wp_customize->add_section( 'ecommerce_plus_pagination', array(
	'title'               => esc_html__('Pagination','ecommerce-plus'),
	'description'         => esc_html__( 'Pagination options.', 'ecommerce-plus' ),
	'panel'               => 'ecommerce_plus_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[pagination_enable]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[pagination_enable]',
	array(
		'section'   => 'ecommerce_plus_pagination',
		'label'     => esc_html__( 'Enable Pagination', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// Site layout setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[pagination_type]', array(
	'sanitize_callback'   => 'ecommerce_plus_sanitize_select',
	'default'             => 'numeric',
	'type'      => 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'ecommerce-plus' ),
	'section'             => 'ecommerce_plus_pagination',
	'type'                => 'select',
	'choices'			  => ecommerce_plus_pagination_options(),
	'active_callback'	  => 'ecommerce_plus_is_pagination_enable',
) );
