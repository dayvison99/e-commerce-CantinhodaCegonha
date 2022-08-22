<?php

global $ecommerce_plus_options;

$wp_customize->add_section( 'ecommerce_plus_preloader', array(
	'title'             => esc_html__( 'Preloader','ecommerce-plus' ),
	'description'       => esc_html__( 'Select preloader style.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_theme_options_panel',
) );


// Prealoader selection
$wp_customize->add_setting( 'ecommerce_plus_options[prealoader_style]' , array(
	'default'   		=> $ecommerce_plus_options['prealoader_style'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'				=> 'option'
));


if(ecommerce_plus_extra_plugin()) {

	$wp_customize->add_control('ecommerce_plus_options[prealoader_style]' , array(
		'label' 	=> __('Preloader Style','ecommerce-plus' ),
		'section' 	=> 'ecommerce_plus_preloader',
		'type'		=> 'select',
		'choices'	=> array (
							'' => esc_html__('None', 'ecommerce-plus'),
							'0' => esc_html__('Spinner', 'ecommerce-plus'),
							'1' => esc_html__('Spinner Dots', 'ecommerce-plus'),
							'2' => esc_html__('Spinner Rectangle', 'ecommerce-plus'),
							'3' => esc_html__('Spinner Double', 'ecommerce-plus'),
							'4' => esc_html__('Chase', 'ecommerce-plus'),
							'5' => esc_html__('Folding Cube', 'ecommerce-plus'),
							'6' => esc_html__('Fading Circle', 'ecommerce-plus'),						
						),
	));

} else {

	$wp_customize->add_control('ecommerce_plus_options[prealoader_style]' , array(
		'label' 	=> __('Preloader Style','ecommerce-plus' ),
		'section' 	=> 'ecommerce_plus_preloader',
		'type'		=> 'select',
		'choices'	=> array (
							'' => esc_html__('None', 'ecommerce-plus'),
							'4' => esc_html__('Chase', 'ecommerce-plus'),
						),
	));

}


// Notice
if (!ecommerce_plus_extra_plugin()) {

	$wp_customize->add_setting( 'ecommerce_plus_options[preloader_notice]',
	   array(
		  'default' => '',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'wp_filter_nohtml_kses'
	   )
	);
	
	$wp_customize->add_control( new eCommerce_plus_Custom_Link_Control( $wp_customize, 'ecommerce_plus_options[preloader_notice]',
	   array(
		  'link' => ECOMMERCE_PLUS_URI,
		  'description'  => esc_html__( 'More Preloaders and options, Go Pro...' , 'ecommerce-plus' ),
		  'section' => 'ecommerce_plus_preloader'
	   )
	) );

}
