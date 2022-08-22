<?php
$ecommerce_plus_options = ecommerce_plus_get_theme_options();

// Add service section
$wp_customize->add_section( 'ecommerce_plus_product_category_section', array(
	'title'             => esc_html__( 'Category Portfolio','ecommerce-plus' ),
	'description'       => esc_html__( 'Featured Category Section Options. If this content not displayed, First create a page from home-page-template and set as home page. Then open customizer.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_home_panel',
));

$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[featured_category_0]', array(
	'selector' => '.product-category-portfolio',
) );


//height
$wp_customize->add_setting( 'ecommerce_plus_options[featured_category_height]', array(
	'default'			=> $ecommerce_plus_options['featured_category_height'],
	'sanitize_callback' => 'absint',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[featured_category_height]', array(
	'label'           	=> esc_html__( 'Item Height', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_product_category_section',
	'type'				=> 'number',
) );


// columns
$wp_customize->add_setting( 'ecommerce_plus_options[featured_category_colums]', array(
	'default'          	=> $ecommerce_plus_options['featured_category_colums'],
	'sanitize_callback' => 'ecommerce_plus_sanitize_select',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[featured_category_colums]', array(
	'label'             => esc_html__( 'Number of Colums', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_product_category_section',
	'type'				=> 'select',
	'choices'			=> 	array(
							"col-md-12 col-sm-12 col-lg-12 col-xs-12"=> 1,
							"col-md-6 col-sm-6 col-lg-6 col-xs-6" 	=> 2,
							"col-md-4 col-sm-4 col-lg-4 col-xs-6" 	=> 3,
							"col-md-3 col-sm-3 col-lg-3 col-xs-6" 	=> 4,
							"col-sm-2" 								=> 5,
							"col-md-2 col-sm-2 col-lg-2 col-xs-6" 	=> 6,		
						),
));



for ($i = 0 ; $i< 10 ; $i++) {

	// product categories
	$wp_customize->add_setting( "ecommerce_plus_options[featured_category_".$i."]", array(
		'default'          	=> $ecommerce_plus_options['featured_category_'.$i],
		'sanitize_callback' => 'ecommerce_plus_sanitize_select',
		'type'      		=> 'option',
	) );
	
	$wp_customize->add_control( 'ecommerce_plus_options[featured_category_'.$i.']', array(
		'label'             => esc_html__( 'Select Product Category', 'ecommerce-plus' ),
		'section'           => 'ecommerce_plus_product_category_section',
		'type'				=> 'select',
		'choices'			=> ecommerce_plus_get_product_categories(),
	) );

}