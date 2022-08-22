<?php
/**
 * Excerpt options
 *
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

// Add excerpt section
$wp_customize->add_section( 'ecommerce_plus_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','ecommerce-plus' ),
	'description'       => esc_html__( 'Excerpt is a part (usually a number of words) taken from page, post or content. You can adjust the length here' , 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[long_excerpt_length]', array(
	'sanitize_callback' => 'ecommerce_plus_sanitize_number_range',
	'validate_callback' => 'ecommerce_plus_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'ecommerce-plus' ),
	'description' 		=> esc_html__( 'Number of words to be displayed in archive page/search page.', 'ecommerce-plus' ),
	'section'     		=> 'ecommerce_plus_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );

// read more text setting and control
$wp_customize->add_setting( 'ecommerce_plus_options[read_more_text]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['read_more_text'],
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[read_more_text]', array(
	'label'           	=> esc_html__( 'Read More Text Label', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_excerpt_section',
	'type'				=> 'text',
) );
