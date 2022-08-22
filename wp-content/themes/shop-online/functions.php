<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

require_once (get_stylesheet_directory() . '/inc/default-settings.php');
require_once (get_stylesheet_directory() . '/inc/styles-enqueue.php');

// BEGIN ENQUEUE 

if ( !function_exists( 'shop_online_locale_css' ) ):
    function shop_online_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'shop_online_locale_css' );

if ( !function_exists( 'shop_online_parent_css' ) ):
    function shop_online_parent_css() {
        wp_enqueue_style( 'shop_online_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'shop_online_parent_css', 10 );

// END ENQUEUE

add_action( 'customize_register', 'shop_online_customizer_settings' );

function shop_online_customizer_settings( $wp_customize ) {

	global $ecommerce_plus_options;	
	
	$wp_customize->add_section( 'ecommerce_plus_woo_options', array(
		'title'             => esc_html__( 'Shop Page','shop-online' ),
		'description'       => esc_html__( 'WooCommerce plugin related options. You can create pages and add before and after shop page. Also set shop page as home page.', 'shop-online' ),
		'panel'             => 'ecommerce_plus_theme_options_panel',
		'priority'   		=> 6,
	) );

		
	//shop pages 1
	$wp_customize->add_setting('ecommerce_plus_options[before_shop]' , array(
		'default'    		=> $ecommerce_plus_options['before_shop'],
		'sanitize_callback' => 'absint',
		'type'				=>'option',

	));

	$wp_customize->add_control('ecommerce_plus_options[before_shop]' , array(
		'label' 	=> __('Page Before Shop Page', 'shop-online' ),
		'section' 	=> 'ecommerce_plus_woo_options',
		'type'		=> 'dropdown-pages',
	) );	

	
	//shop pages 2
	$wp_customize->add_setting('ecommerce_plus_options[after_shop]' , array(
		'default'    		=> $ecommerce_plus_options['after_shop'],
		'sanitize_callback' => 'absint',
		'type'				=>'option',

	));

	$wp_customize->add_control('ecommerce_plus_options[after_shop]' , array(
		'label' => __('Page After Shop Page', 'shop-online' ),
		'section' => 'ecommerce_plus_woo_options',
		'type'=> 'dropdown-pages',
	) );
	

	// banner image
	$wp_customize->add_setting( 'ecommerce_plus_options[banner_image]' , 
		array(
			'default' 		=> '',
			'capability'     => 'edit_theme_options',
			'type'				=>'option',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'ecommerce_plus_options[banner_image]' ,
		array(
			'label'         => __( 'Banner Image', 'shop-online' ),
			'description'	=> __('Upload banner image', 'shop-online'),
			'settings'  	=> 'ecommerce_plus_options[banner_image]',
			'section'       => 'ecommerce_plus_header',
		))
	);
	
	//
	$wp_customize->add_setting('ecommerce_plus_options[banner_link]' , array(
		'default'    => '#',
		'sanitize_callback' => 'esc_url_raw',
		'type'				=>'option',
	));
	
	$wp_customize->add_control('ecommerce_plus_options[banner_link]' , array(
		'label'   => __('Banner Image Link', 'shop-online' ),
		'section' => 'ecommerce_plus_header',
		'type'    => 'url',
	) );
	
	
	//countdown section
	$wp_customize->add_section( 'ecommerce_plus_countdown_section', array(
		'title'             => esc_html__( 'Countdown Timer','shop-online' ),
		'description'       => esc_html__( 'Add a countdown timer with messege. Edit year, month, date and messege and save to display.', 'shop-online' ),
		'panel'             => 'ecommerce_plus_theme_options_panel',
		'priority'   		=> 5,
	) );
	
	
	//enable countdown
	$wp_customize->add_setting( 'ecommerce_plus_options[countdown_enable]', array(
		'default'   		=> false,
		'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
		'type'      		=> 'option'
	));
	
	
	$wp_customize->add_control('ecommerce_plus_options[countdown_enable]',
		array(
			'section'   => 'ecommerce_plus_countdown_section',
			'label'     => esc_html__( 'Enable Countdown Timer', 'shop-online' ),
			'type'      => 'checkbox'
	));
	
	$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[countdown_enable]', array(
		'selector' => '#countdown-timer-text',
	) );
	
	//enable days
	$wp_customize->add_setting( 'ecommerce_plus_options[countdown_enable_days]', array(
		'default'   		=> true,
		'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
		'type'      		=> 'option'
	));
	
	
	$wp_customize->add_control('ecommerce_plus_options[countdown_enable_days]',
		array(
			'section'   => 'ecommerce_plus_countdown_section',
			'label'     => esc_html__( 'Enable Days', 'shop-online' ),
			'type'      => 'checkbox'
	));
	
	//enable hours
	$wp_customize->add_setting( 'ecommerce_plus_options[countdown_enable_hours]', array(
		'default'   		=> true,
		'sanitize_callback' => 'ecommerce_plus_sanitize_checkbox',
		'type'      		=> 'option'
	));
	
	
	$wp_customize->add_control('ecommerce_plus_options[countdown_enable_hours]',
		array(
			'section'   => 'ecommerce_plus_countdown_section',
			'label'     => esc_html__( 'Enable Hours', 'shop-online' ),
			'type'      => 'checkbox'
	));	
	
	$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[countdown_enable]', array(
		'selector' => '#countdown-timer-text',
	) );
		
	// year
	$wp_customize->add_setting( 'ecommerce_plus_options[countdown_year]', array(
		'default'          	=> '2025',
		'sanitize_callback' => 'ecommerce_plus_sanitize_select',
		'type'      		=> 'option',
	) );
	
	$wp_customize->add_control( 'ecommerce_plus_options[countdown_year]', array(
		'label'             => esc_html__( 'Year', 'shop-online' ),
		'section'           => 'ecommerce_plus_countdown_section',
		'type'				=> 'select',
		'choices'			=> 	array(
								"2021"  => 2021,
								"2022" 	=> 2022,
								"2023" 	=> 2023,
								"2024" 	=> 2024,
								"2025" 	=> 2025,
								"2026" 	=> 2026,
								"2027" 	=> 2027,
								"2028" 	=> 2028,
								"2029" 	=> 2029,
								"2030" 	=> 2030,		
							),
	));
		
		
	// month
	$wp_customize->add_setting( 'ecommerce_plus_options[countdown_month]', array(
		'default'          	=> '12',
		'sanitize_callback' => 'ecommerce_plus_sanitize_select',
		'type'      		=> 'option',
	) );
	
	$wp_customize->add_control( 'ecommerce_plus_options[countdown_month]', array(
		'label'             => esc_html__( 'Month', 'shop-online' ),
		'section'           => 'ecommerce_plus_countdown_section',
		'type'				=> 'select',
		'choices'			=> 	array(
								"1"     => 1,
								"2" 	=> 2,
								"3" 	=> 3,
								"4" 	=> 4,
								"5" 	=> 5,
								"6" 	=> 6,
								"7" 	=> 7,
								"8" 	=> 8,
								"9" 	=> 9,
								"10" 	=> 10,
								"11" 	=> 11,
								"12" 	=> 12,		
							),
	));
	
	// date
	$wp_customize->add_setting( 'ecommerce_plus_options[countdown_date]', array(
		'default'          	=> '12',
		'sanitize_callback' => 'ecommerce_plus_sanitize_select',
		'type'      		=> 'option',
	) );
	
	$wp_customize->add_control( 'ecommerce_plus_options[countdown_date]', array(
		'label'             => esc_html__( 'Date', 'shop-online' ),
		'section'           => 'ecommerce_plus_countdown_section',
		'type'				=> 'select',
		'choices'			=> 	array(
								"1"     => 1,
								"2" 	=> 2,
								"3" 	=> 3,
								"4" 	=> 4,
								"5" 	=> 5,
								"6" 	=> 6,
								"7" 	=> 7,
								"8" 	=> 8,
								"9" 	=> 9,
								"10" 	=> 10,
								"11" 	=> 11,
								"12" 	=> 12,
								"13"     => 13,
								"14" 	=> 14,
								"15" 	=> 15,
								"16" 	=> 16,
								"17" 	=> 17,
								"18" 	=> 18,
								"19" 	=> 19,
								"20" 	=> 20,
								"21" 	=> 21,
								"22" 	=> 22,
								"23" 	=> 23,
								"24" 	=> 24,													
								"25" 	=> 25,
								"26" 	=> 26,
								"27" 	=> 27,
								"28" 	=> 28,
								"29" 	=> 29,
								"30" 	=> 30,
								"31" 	=> 31,								
							),
	));



	//text
	$wp_customize->add_setting('ecommerce_plus_options[countdown_text]' , array(
		'default'    		=> esc_html__('Discount upto 25%, Limited time offer', 'shop-online' ),
		'sanitize_callback' => 'sanitize_text_field',
		'type'				=>'option',
	));
	
	$wp_customize->add_control('ecommerce_plus_options[countdown_text]' , array(
		'label'   => __('Countdown Message', 'shop-online' ),
		'section' => 'ecommerce_plus_countdown_section',
		'type'    => 'text',
	) );
	
	
	//widgets section	
	$wp_customize->add_section( 'header_widgets' , array(
		'title'      => __( 'Home Header Widgets', 'shop-online' ),
		'priority'   => 1,
		'panel' => 'ecommerce_plus_theme_options_panel',
	) );	
	
	$wp_customize->add_setting('ecommerce_plus_options[top_widgets]' , array(
		'default'    => 'col-sm-12',
		'sanitize_callback' => 'ecommerce_plus_sanitize_select',
		'type'=>'option',

	));

	$wp_customize->add_control('ecommerce_plus_options[top_widgets]' , array(
		'label' => __('Select Number of Widgets', 'shop-online' ),
		'section' => 'header_widgets',
		'type'=>'select',
		'choices'=>array(
			'col-sm-12'=> __('1 Widgets', 'shop-online' ),
			'col-sm-6' => __('2 Widgets', 'shop-online' ),
			'col-sm-4' => __('3 Widgets', 'shop-online' ),
			'col-sm-3' => __('4 Widgets', 'shop-online' ),
			'col-sm-2' => __('6 Widgets', 'shop-online' ),
		),
	) );



}// end customizer


/*
 * Banner image
 */
add_action('shop_online_banner', 'shop_online_banner');

function shop_online_banner(){

$shop_online_options  = ecommerce_plus_get_theme_options(); 


	if($shop_online_options['banner_image'] !='') { 
	
	?>
		<section id="top-banner">
			<div class="text-center">
				<?php 
					echo '<a href="'.esc_url($shop_online_options['banner_link']).'" ><img src="'.esc_url($shop_online_options['banner_image']).'" /></a>';	
				?>
			</div>
		</section>
	<?php	
	}

}
 


//add child theme widget area

function shop_online_widgets_init(){

	/* header sidebar */
	$shop_online_options = ecommerce_plus_get_theme_options();
	if (!isset($shop_online_options['header_widgets'])) $shop_online_options['header_widgets'] = "col-sm-12";

	register_sidebar(
		array(
			'name'          => __( 'Home Page Header Widgets', 'shop-online' ),
			'id'            => 'header-widgets',
			'description'   => __( 'Add widgets to appear in Header.', 'shop-online' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s '.$shop_online_options['header_widgets'].' text-center">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action( 'widgets_init', 'shop_online_widgets_init' );
