<?php
/**
 * Layout options
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

// Add sidebar section
$wp_customize->add_section( 'ecommerce_plus_layout', array(
	'title'               => esc_html__('Layout','ecommerce-plus'),
	'description'         => esc_html__( 'Manage site layout options. Also, you can edit header layouts for each page settings.', 'ecommerce-plus' ),
	'panel'               => 'ecommerce_plus_theme_options_panel',
) );



//
$wp_customize->add_setting( 'ecommerce_plus_options[layout_label2]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[layout_label2]',
   array(
	  'description'  => esc_html__( 'Site Layouts', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_layout'
   )
) );

// Site layout setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[site_layout]', array(
	'sanitize_callback'   => 'ecommerce_plus_sanitize_select',
	'default'             => $options['site_layout'],
	'type'				=> 'option',
) );


$wp_customize->add_control(  new ecommerce_plus_Custom_Radio_Image_Control ( $wp_customize, 'ecommerce_plus_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'ecommerce-plus' ),
	'section'             => 'ecommerce_plus_layout',
	'choices'			  => ecommerce_plus_site_layout(),
) ) );


//
$wp_customize->add_setting( 'ecommerce_plus_options[layout_label3]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[layout_label3]',
   array(
	  'description'  => esc_html__( 'WooCommerce Layouts', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_layout'
   )
) );

// Checkout page

$wp_customize->add_setting( 'ecommerce_plus_options[two_colum_checkout]', array(
	'default'   		=> true,
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
	'type'      		=> 'option'
));

$wp_customize->add_control('ecommerce_plus_options[two_colum_checkout]',
	array(
		'section'   => 'ecommerce_plus_layout',
		'label'     => esc_html__( 'WooCommerce Two Colum Checkout Page', 'ecommerce-plus' ),
		'type'      => 'checkbox'
));

//WooCommerce Sidebars

$wp_customize->add_setting( 'ecommerce_plus_options[woo_sidebar_position]', array(
	'sanitize_callback'   	=> 'ecommerce_plus_sanitize_select',
	'default'             	=> $options['sidebar_position'],
	'type'					=> 'option',
));

$wp_customize->add_control(  new ecommerce_plus_Custom_Radio_Image_Control ( $wp_customize, 'ecommerce_plus_options[woo_sidebar_position]', array(
	'label'               => esc_html__( 'WooCommerce Sidebar Layout', 'ecommerce-plus' ),
	'section'             => 'ecommerce_plus_layout',
	'choices'			  => ecommerce_plus_woo_sidebar_position(),
)));


//
$wp_customize->add_setting( 'ecommerce_plus_options[layout_label4]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[layout_label4]',
   array(
	  'description'  => esc_html__( 'Post Sidebar Layouts', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_layout'
   )
) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'ecommerce_plus_sanitize_select',
	'default'             => $options['post_sidebar_position'],
	'type'      => 'option',
) );

$wp_customize->add_control(  new ecommerce_plus_Custom_Radio_Image_Control ( $wp_customize, 'ecommerce_plus_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Layout', 'ecommerce-plus' ),
	'section'             => 'ecommerce_plus_layout',
	'choices'			  => ecommerce_plus_sidebar_position(),
) ) );


//
$wp_customize->add_setting( 'ecommerce_plus_options[layout_label5]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[layout_label5]',
   array(
	  'description'  => esc_html__( 'Page Sidebar Layouts', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_layout'
   )
) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'ecommerce_plus_sanitize_select',
	'default'             => $options['page_sidebar_position'],
	'type'				=> 'option',
	
) );

$wp_customize->add_control( new ecommerce_plus_Custom_Radio_Image_Control( $wp_customize, 'ecommerce_plus_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Layout', 'ecommerce-plus' ),
	'section'             => 'ecommerce_plus_layout',
	'choices'			  => ecommerce_plus_sidebar_position(),
) ) );


	//
	$wp_customize->add_setting( 'ecommerce_plus_options[layout_label6]',
	   array(
		  'default' => '',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'wp_filter_nohtml_kses'
	   )
	);
	
	$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[layout_label6]',
	   array(
		  'description'  => esc_html__( 'Site Width', 'ecommerce-plus' ),
		  'section' => 'ecommerce_plus_layout'
	   )
	) );

	//
	$wp_customize->add_setting( 'ecommerce_plus_options[header_width]' , array(
	'default'    => $ecommerce_plus_options['header_width'],
	'sanitize_callback' => 'absint',
	'type'=>'option'
	));
	
	$wp_customize->add_control('ecommerce_plus_options[header_width]' , array(
	'label' => __('Header Width','ecommerce-plus' ),
	'section' => 'ecommerce_plus_layout',
	'type'	=>'number',
	) );
	

	//
	$wp_customize->add_setting( 'ecommerce_plus_options[content_width]' , array(
	'default'    => $ecommerce_plus_options['content_width'],
	'sanitize_callback' => 'absint',
	'type'=>'option'
	));
	
	$wp_customize->add_control('ecommerce_plus_options[content_width]' , array(
	'label' => __('Content Width','ecommerce-plus' ),
	'section' => 'ecommerce_plus_layout',
	'type'	=>'number',
	) );
	
	

	//
	$wp_customize->add_setting( 'ecommerce_plus_options[footer_width]' , array(
	'default'    => $ecommerce_plus_options['footer_width'],
	'sanitize_callback' => 'absint',
	'type'=>'option'
	));
	
	$wp_customize->add_control('ecommerce_plus_options[footer_width]' , array(
	'label' => __('Footer Width','ecommerce-plus' ),
	'section' => 'ecommerce_plus_layout',
	'type'	=>'number',
	) );		