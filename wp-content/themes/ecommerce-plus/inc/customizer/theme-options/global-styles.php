<?php
/**
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

$wp_customize->add_section( 'ecommerce_plus_styles', array(
	'title'             => esc_html__( 'Fonts','ecommerce-plus' ),
	'description'       => esc_html__( 'Edit heading, button and global styles.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_theme_options_panel',
) );


// Post Category
$wp_customize->add_setting( 'ecommerce_plus_options[featured_heading_style]' , array(
	'default'   		=> $ecommerce_plus_options['featured_heading_style'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'				=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[featured_heading_style]' , array(
	'label' 	=> __('Featured Title Style','ecommerce-plus' ),
	'section' 	=> 'ecommerce_plus_styles',
	'type'		=> 'select',
	'choices'	=> array (
						'default' => esc_html__('Default', 'ecommerce-plus'),
						'full-underline' => esc_html__('Full Underline', 'ecommerce-plus'),
					),
));


// Styles

$wp_customize->add_setting(
	'ecommerce_plus_options[heading_font]', array(
		'default'           => $ecommerce_plus_options['heading_font'],		
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',  
		'type'        		=> 'option',
));

$wp_customize->add_control( 'ecommerce_plus_options[heading_font]' , array(
	'label' 	=> __('Heading Font Family','ecommerce-plus'),
	'section' 	=> 'ecommerce_plus_styles',
	'type'		=> 'text',
));

//
$wp_customize->add_setting(
	'ecommerce_plus_options[body_font]', array(
		'default'           => $ecommerce_plus_options['body_font'],			
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',  
		'type'        		=> 'option',
));

$wp_customize->add_control( 'ecommerce_plus_options[body_font]' , array(
	'label' 	=> __('Body Font Family','ecommerce-plus'),
	'section' 	=> 'ecommerce_plus_styles',
	'active_callback' 	=> 'ecommerce_plus_extra_plugin',
	'type'		=> 'text',
));



// Notice
$wp_customize->add_setting( 'ecommerce_plus_options[style_notice]',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Link_Control( $wp_customize, 'ecommerce_plus_options[style_notice]',
   array(
      'link' => ECOMMERCE_PLUS_URI,
      'description'  => esc_html__( 'Change body fonts and More font options, Go Pro...' , 'ecommerce-plus' ),
      'section' => 'ecommerce_plus_styles'
   )
) );
