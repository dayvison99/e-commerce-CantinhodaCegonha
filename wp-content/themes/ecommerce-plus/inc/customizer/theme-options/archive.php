<?php
/**
 * Archive options
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
global $ecommerce_plus_options;

// Add archive section
$wp_customize->add_section( 'ecommerce_plus_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive/Post','ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'ecommerce-plus' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'ecommerce-plus' ),
	'section'           => 'ecommerce_plus_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'ecommerce_plus_is_latest_posts'
) );


//
$wp_customize->add_setting( 'ecommerce_plus_options[archive_label]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[archive_label]',
   array(
	  'description'  => esc_html__( 'Archive meta and control', 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_archive_section'
   )
) );

// Archive date meta setting and control.

$wp_customize->add_setting( 'ecommerce_plus_options[hide_date]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[hide_date]',
	array(
		'section'   => 'ecommerce_plus_archive_section',
		'label'     => esc_html__( 'Hide Date', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// Archive author category setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[hide_category]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[hide_category]',
	array(
		'section'   => 'ecommerce_plus_archive_section',
		'label'     => esc_html__( 'Hide Category', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);



/**
 * pagination options
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */

//
$wp_customize->add_setting( 'ecommerce_plus_options[archive_label2]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[archive_label2]',
   array(
	  'description'  => esc_html__( 'Pagination Settings' , 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_archive_section'
   )
) );

// Pagination
$wp_customize->add_setting( 'ecommerce_plus_options[pagination_enable]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[pagination_enable]',
	array(
		'section'   => 'ecommerce_plus_archive_section',
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
	'section'             => 'ecommerce_plus_archive_section',
	'type'                => 'select',
	'choices'			  => ecommerce_plus_pagination_options(),
	'active_callback'	  => 'ecommerce_plus_is_pagination_enable',
) );


/**
 * Excerpt options
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */


$wp_customize->add_setting( 'ecommerce_plus_options[archive_label3]',
   array(
	  'default' => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);

$wp_customize->add_control( new eCommerce_plus_Custom_Label_Control( $wp_customize, 'ecommerce_plus_options[archive_label3]',
   array(
	  'description'  => esc_html__( 'Single Post' , 'ecommerce-plus' ),
	  'section' => 'ecommerce_plus_archive_section'
   )
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'ecommerce_plus_options[single_post_hide_date]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[single_post_hide_date]',
	array(
		'section'   => 'ecommerce_plus_archive_section',
		'label'     => esc_html__( 'Hide Date', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// Archive author meta setting and control.

$wp_customize->add_setting( 'ecommerce_plus_options[single_post_hide_author]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[single_post_hide_author]',
	array(
		'section'   => 'ecommerce_plus_archive_section',
		'label'     => esc_html__( 'Hide Author', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// Archive author category setting and control.

$wp_customize->add_setting( 'ecommerce_plus_options[single_post_hide_category]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[single_post_hide_category]',
	array(
		'section'   => 'ecommerce_plus_archive_section',
		'label'     => esc_html__( 'Hide Author', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);

// Archive tag category setting and control.

$wp_customize->add_setting( 'ecommerce_plus_options[single_post_hide_tags]', array(
	'default'   => true,
	'type'      => 'option',
	'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
 ) );

$wp_customize->add_control('ecommerce_plus_options[single_post_hide_tags]',
	array(
		'section'   => 'ecommerce_plus_archive_section',
		'label'     => esc_html__( 'Hide Tag', 'ecommerce-plus' ),
		'type'      => 'checkbox'
		 )
);


