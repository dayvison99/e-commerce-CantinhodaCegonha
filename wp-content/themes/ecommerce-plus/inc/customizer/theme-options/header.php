<?php
/**
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

$wp_customize->add_section( 'ecommerce_plus_header', array(
	'title'             => esc_html__( 'Header','ecommerce-plus' ),
	'description'       => esc_html__( 'Edit Header layout and other options. You can create transparent header for each page by editing page and selecting transparent header option from right panel.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_theme_options_panel',
) );




//
$wp_customize->add_setting( 'ecommerce_plus_options[header_label]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[header_label]',
   array(
	  'description'  => esc_html__( 'Menu Bar Button', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_header'
   )
) );

// menu button
$wp_customize->add_setting( 'ecommerce_plus_options[topbar_login_register_enable]', array(
	'default'   => $options['topbar_login_register_enable'] ,
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
	'type'      => 'option'
 ) );

$wp_customize->add_control('ecommerce_plus_options[topbar_login_register_enable]',
	array(
		'section'   => 'ecommerce_plus_header',
		'label'     => esc_html__( 'Display Header Button', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

		
$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[topbar_login_register_enable]', array(
	'selector' => '#masthead .login-register ul li',
) );

// login setting and control
$wp_customize->add_setting( 'ecommerce_plus_options[topbar_login_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['topbar_login_label'],
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[topbar_login_label]', array(
	'label'           	=> esc_html__( 'Button Label', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_header',
	'type'				=> 'text',
) );


// login url setting and control
$wp_customize->add_setting( 'ecommerce_plus_options[topbar_login_url]', array(
	'sanitize_callback' => 'esc_url_raw',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[topbar_login_url]', array(
	'label'           	=> esc_html__( 'Url [Link]', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_header',
	'type'				=> 'url',
) );


//
$wp_customize->add_setting( 'ecommerce_plus_options[header_label0]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[header_label0]',
   array(
	  'description'  => esc_html__( 'Header Layouts', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_header'
   )
) );



//Header
$wp_customize->add_setting( 'ecommerce_plus_options[site_header_layout]', array(
	'sanitize_callback'   => 'ecommerce_plus_sanitize_select',
	'default'             => $options['site_header_layout'],
	'type'				=> 'option',
) );


$wp_customize->add_control(  new ecommerce_plus_Custom_Radio_Image_Control ( $wp_customize, 'ecommerce_plus_options[site_header_layout]', array(
	'label'               => esc_html__( 'Site Header Layout', 'ecommerce-plus' ),
	'description'         => esc_html__( '[Also you can, Edit page|Post using WordPress editor and Change header layout to change each page.]', 'ecommerce-plus' ),
	'section'             => 'ecommerce_plus_header',
	'choices'			  => ecommerce_plus_header_layout(),
) ) );



// Ajax search
$wp_customize->add_setting( 'ecommerce_plus_options[header_label4]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[header_label4]',
   array(
	  'description'  => esc_html__( 'Header AJAX Search', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_header'
   )
) );

//
$wp_customize->add_setting( 'ecommerce_plus_options[ajax_search]', array(
	'default'   => $options['ajax_search'] ,
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
	'type'      => 'option'
 ) );

$wp_customize->add_control('ecommerce_plus_options[ajax_search]',
	array(
		'section'   => 'ecommerce_plus_header',
		'label'     => esc_html__( 'Enable [Install AJAX Search for WooCommerce Plugin]', 'ecommerce-plus' ),
		'type'      => 'checkbox'
	)
);




//
$wp_customize->add_setting( 'ecommerce_plus_options[header_label2]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[header_label2]',
   array(
	  'description'  => esc_html__( 'Header Colors', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_header'
   )
) );

// menu background colour
$wp_customize->add_setting(
	'ecommerce_plus_options[header_bg_color]',
	array(
		'default'     => $options['header_bg_color'],
		'type'        => 'option',
		'transport'   => 'refresh',				
		'sanitize_callback' => 'ecommerce_plus_sanitize_rgba_color',
	)
);

$wp_customize->add_control(
	new Ecommerce_Plus_Alpha_Color_Control(
		$wp_customize,
		'ecommerce_plus_options[header_bg_color]',
		array(
			'label'         =>  __('Header Background','ecommerce-plus' ),
			'section'       => 'ecommerce_plus_header',					
			'settings'      => 'ecommerce_plus_options[header_bg_color]',
			'description'   =>  __('Drag alpha slider for transparency.', 'ecommerce-plus'),
			'show_opacity'  => true,
		)
	)
);		


//
$wp_customize->add_setting( 'ecommerce_plus_options[header_label3]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[header_label3]',
   array(
	  'description'  => esc_html__( 'Menu Bar Colors [Header Storefront Layout]', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_header'
   )
) );

// menubar colors

$wp_customize->add_setting(
	'ecommerce_plus_options[store_menu_color]',
	array(
		'default'     => $options['store_menu_color'],
		'type'        => 'option',
		'transport'   => 'refresh',				
		'sanitize_callback' => 'ecommerce_plus_sanitize_rgba_color',
	)
);

$wp_customize->add_control(
	new Ecommerce_Plus_Alpha_Color_Control(
		$wp_customize,
		'ecommerce_plus_options[store_menu_color]',
		array(
			'label'         =>  __('Menu Text Color','ecommerce-plus' ),
			'section'       => 'ecommerce_plus_header',					
			'settings'      => 'ecommerce_plus_options[store_menu_color]',
			'description'   =>  __('(Header storefron style menu)', 'ecommerce-plus'),
			'show_opacity'  => true,
		)
	)
);

//
$wp_customize->add_setting(
	'ecommerce_plus_options[store_menubar_color]',
	array(
		'default'     => $options['store_menubar_color'],
		'type'        => 'option',
		'transport'   => 'refresh',				
		'sanitize_callback' => 'ecommerce_plus_sanitize_rgba_color',
	)
);

$wp_customize->add_control(
	new Ecommerce_Plus_Alpha_Color_Control(
		$wp_customize,
		'ecommerce_plus_options[store_menubar_color]',
		array(
			'label'         =>  __('Menu Background Color','ecommerce-plus' ),
			'section'       => 'ecommerce_plus_header',					
			'settings'      => 'ecommerce_plus_options[store_menubar_color]',
			'description'   =>  __('(Header storefront style menu)', 'ecommerce-plus'),
			'show_opacity'  => true,
		)
	)
);

//
$wp_customize->add_setting( 'ecommerce_plus_options[menubar_border_height]', array(
	'sanitize_callback' => 'absint',
	'default'			=> $options['menubar_border_height'],
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[menubar_border_height]', array(
	'label'           	=> esc_html__( 'Menubar Line Height', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_header',
	'type'				=> 'number',
) );


//
$wp_customize->add_setting(
	'ecommerce_plus_options[menubar_border_color]',
	array(
		'default'     => $options['menubar_border_color'],
		'type'        => 'option',
		'transport'   => 'refresh',				
		'sanitize_callback' => 'ecommerce_plus_sanitize_rgba_color',
	)
);

$wp_customize->add_control(
	new Ecommerce_Plus_Alpha_Color_Control(
		$wp_customize,
		'ecommerce_plus_options[menubar_border_color]',
		array(
			'label'         =>  __('Menu Border Color','ecommerce-plus' ),
			'section'       => 'ecommerce_plus_header',					
			'settings'      => 'ecommerce_plus_options[menubar_border_color]',
			'description'   =>  __('(Header storefront style menu)', 'ecommerce-plus'),
			'show_opacity'  => true,
		)
	)
);


