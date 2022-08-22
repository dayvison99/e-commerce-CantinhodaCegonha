<?php
function storebiz_header_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Header Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'header_section', 
		array(
			'priority'      => 2,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Header', 'storebiz'),
		) 
	);
	
	/*=========================================
	Storebiz Site Identity
	=========================================*/
	$wp_customize->add_section(
        'title_tagline',
        array(
        	'priority'      => 1,
            'title' 		=> __('Site Identity','storebiz'),
			'panel'  		=> 'header_section',
		)
    );

	/*=========================================
	Header Navigation
	=========================================*/	
	$wp_customize->add_section(
        'hdr_navigation',
        array(
        	'priority'      => 3,
            'title' 		=> __('Header Navigation','storebiz'),
			'panel'  		=> 'header_section',
		)
    );
		
    // Cart
	$wp_customize->add_setting(
		'hdr_nav_cart'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'hdr_nav_cart',
		array(
			'type' => 'hidden',
			'label' => __('Cart','storebiz'),
			'section' => 'hdr_navigation',
			'priority' => 2,
		)
	);

	// hide/show
	$wp_customize->add_setting( 
		'hide_show_cart' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_checkbox',
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_cart', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storebiz' ),
			'section'     => 'hdr_navigation',
			'type'        => 'checkbox',
			'priority' => 2,
		) 
	);	
	
	// Header Hiring Section
	$wp_customize->add_setting(
		'hdr_nav_search_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'hdr_nav_search_head',
		array(
			'type' => 'hidden',
			'label' => __('Search','storebiz'),
			'section' => 'hdr_navigation',
			'priority'  => 3,
		)
	);	
	
	// hide/show
	$wp_customize->add_setting( 
		'hs_nav_search' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_checkbox',
		) 
	);
	
	$wp_customize->add_control(
	'hs_nav_search', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storebiz' ),
			'section'     => 'hdr_navigation',
			'type'        => 'checkbox',
			'priority' => 3,
		) 
	);
	
	
	// Header Hiring Section
	$wp_customize->add_setting(
		'hdr_nav_acc_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'hdr_nav_acc_head',
		array(
			'type' => 'hidden',
			'label' => __('Account','storebiz'),
			'section' => 'hdr_navigation',
			'priority'  => 5,
		)
	);	
	
	// hide/show
	$wp_customize->add_setting( 
		'hs_nav_account' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_checkbox',
		) 
	);
	
	$wp_customize->add_control(
	'hs_nav_account', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storebiz' ),
			'section'     => 'hdr_navigation',
			'type'        => 'checkbox',
			'priority' => 6,
		) 
	);
	
	/*=========================================
	Sticky Header
	=========================================*/	
	$wp_customize->add_section(
        'sticky_header_set',
        array(
        	'priority'      => 4,
            'title' 		=> __('Sticky Header','storebiz'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Heading
	$wp_customize->add_setting(
		'sticky_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'sticky_head',
		array(
			'type' => 'hidden',
			'label' => __('Sticky Header','storebiz'),
			'section' => 'sticky_header_set',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_sticky' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_sticky', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'storebiz' ),
			'section'     => 'sticky_header_set',
			'type'        => 'checkbox'
		) 
	);	
}
add_action( 'customize_register', 'storebiz_header_settings' );