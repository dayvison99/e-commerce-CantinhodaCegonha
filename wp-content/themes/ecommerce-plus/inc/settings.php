<?php 
/**
 * Customizer default options
 *
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 * @return array An array of default values
 */

function ecommerce_plus_get_default_theme_options() {
	$ecommerce_plus_default_options = array(
	
		// Header Options
		'site_header_layout'			=> 'storefront',
		
		'home_section_1'				=> 'ecommerce_plus_post_slider',
		'home_section_2'				=> 'ecommerce_plus_product_showcase',
		'home_section_3'				=> 'ecommerce_plus_product_slider',
		'home_section_4'				=> 'ecommerce_plus_product_slider_2',
		'home_section_5'				=> 'ecommerce_plus_product_category',
		'home_section_6'				=> 'ecommerce_extra_service',
		'home_section_7'				=> 'ecommerce_extra_team',
		'home_section_8'				=> 'ecommerce_plus_cta',
		'home_section_9'				=> 'ecommerce_extra_testimonial',
		'home_section_10'				=> 'ecommerce_plus_contact',
		'home_section_11'				=> '',
		'home_section_12'				=> '',
		
		'prealoader_style'				=> '',
		'ajax_search'					=> false,
		
		//layout
		'footer_width'					=> 1280,
		'content_width'					=> 1280,
		'header_width'					=> 1280,
		
		//countdown
		'countdown_enable'				=> false,		
		'countdown_text'				=> esc_html__('Discount upto 25%, Limited time offer', 'ecommerce-plus' ),
		'countdown_date'				=> '12',				
		'countdown_month'				=> '12',
		'countdown_year'				=> '2025',
		'countdown_enable_hours'		=> true,		
		'countdown_enable_days'			=> true,
			
		//counter
		'countdown_enable'				=> false,
		'countdown_year'				=> '2025',
		'countdown_month'				=> '12',
		'countdown_date'				=> '12',
		'countdown_text'				=> esc_html__('Discount upto 25%, Limited time offer', 'ecommerce-plus' ),		
		
		// styles
		'featured_heading_style'		=> 'default',
		'two_colum_checkout'			=> 'true',
		
		//banner
		'banner_image'					=> '',
		'banner_link'					=> '',		
		
		// Color Options
		'primary_color'					=> '#178dff',		
		'link_color'					=> '#4c4c4c',
		'text_color'					=> '#0f0f0f',
		'link_hover_color'				=> '#178dff',
		'accent_color'					=> '#1a57a3',
		
		'store_menu_color'				=> '#191a1a',
		'store_menubar_color'			=> '#ffffff',		
		
		'header_title_color'			=> '#178dff',
		'header_tagline_color'			=> '#3f444d',
		'header_txt_logo_extra'			=> 'show-all',
		'header_bg_color'				=> '#ffffff',
		
		'header_text_color'				=> '#002a45',
		
		'menubar_border_height'			=> 1,
		'menubar_border_color'			=> '#eaeaea',		
		
		//cta
		'cta_page'						=> '0',
		'cta_text'						=> '',
		'cta_label'						=> esc_html__('CLAIM OFFER', 'ecommerce-plus'),
		'cta_color'						=> '#000',
		'cta_link'						=> '',
		'cta_height'					=> 300,		
		'cta_image'						=> get_template_directory_uri(). '/images/breadcrumb.jpg',
		
		//contact
		'contact_form_shortcode'		=> '[contact-form-7   title="Contact form 1"]',			
		'contact_section_title'			=> esc_html__('Contact Us', 'ecommerce-plus'),
		
		//services
		'service_page'					=> true,
		
		//post slider
		'slider_cat'					=> '0',	
		'slider_height'					=> 450,
		'slider_title_text'				=> true,
		'slider_max'					=> 3,
		'slider_btn_label'				=> esc_html__('Read More', 'ecommerce-plus'),			
		'slider_btn_url'				=> '',
		'slider_button'					=> false,
		'title_text'					=> false,
		
		//product section			
		'product_section_1_product_cat'		=> '',
		'product_section_1_product_feature'	=> '',
		'product_section_1_slider'			=> true,
		'product_section_1_num_products'	=> '',
		'product_section_1_height'			=> '',
		'product_section_1_title'			=> esc_html__('Our Products', 'ecommerce-plus'),
		'product_section_1_image_height'	=> '',
		'product_section_1_speed'			=> '',
		'product_section_1_colums'			=> 'col-md-2 col-sm-2 col-lg-2 col-xs-6',
		'product_section_1_type'			=> 0,
		
		//product section			
		'product_section_2_product_cat'		=> '',
		'product_section_2_product_feature'	=> '',
		'product_section_2_slider'			=> true,
		'product_section_2_num_products'	=> '',
		'product_section_2_height'			=> '',
		'product_section_2_title'			=> esc_html__('Our Products', 'ecommerce-plus'),
		'product_section_2_image_height'	=> '',
		'product_section_2_speed'			=> '',
		'product_section_2_colums'			=> 'col-md-2 col-sm-2 col-lg-2 col-xs-6',
		'product_section_2_type'			=> 0,		
		
		//product section			
		'product_section_3_product_cat'		=> '',
		'product_section_3_product_feature'	=> '',
		'product_section_3_slider'			=> true,
		'product_section_3_num_products'	=> '',
		'product_section_3_height'			=> '',
		'product_section_3_title'			=> esc_html__('Our Products', 'ecommerce-plus'),
		'product_section_3_image_height'	=> '',
		'product_section_3_speed'			=> '',
		'product_section_3_colums'			=> 'col-md-2 col-sm-2 col-lg-2 col-xs-6',
		'product_section_3_type'			=> 0,	
		
		//product section			
		'product_section_4_product_cat'		=> '',
		'product_section_4_product_feature'	=> '',
		'product_section_4_slider'			=> true,
		'product_section_4_num_products'	=> '',
		'product_section_4_height'			=> '',
		'product_section_4_title'			=> esc_html__('Our Products', 'ecommerce-plus'),
		'product_section_4_image_height'	=> '',
		'product_section_4_speed'			=> '',
		'product_section_4_colums'			=> 'col-md-2 col-sm-2 col-lg-2 col-xs-6',
		'product_section_4_type'			=> 0,		

		//product showcase
		'prod_navigation_section_enable'	=> true,			
		'prod_slider_cat_label'				=> esc_html__('Top Categories', 'ecommerce-plus'),
		'prod_slider_cat'					=> '',		
		'prod_slider_height'				=> 450,
		'prod_slider_title_text'			=> true,
		'prod_slider_max'					=> 3,
		'prod_slider_btn_label'				=> esc_html__('View Product', 'ecommerce-plus'),
		'prod_slider_btn_url'				=> '',			
		
		// Fonts
		'heading_font'					=> 'Roboto Condensed',
		'body_font'						=> 'Google Sans',
		
		'contact_section_address'		=> '',
		'contact_section_email'			=> '',
		'contact_section_phone'			=> '',
		'contact_section_hours'			=> '',
		
		'contact_bg_color'				=> '#fbfbfb1c',	
			
		'social_facebook_link'			=> '',
		'social_twitter_link'			=> '',
		'social_whatsapp_link'			=> '',
		'social_pinterest_link'			=> '',
		'social_instagram_link'			=> '',
		'social_linkdin_link'			=> '',
		'social_youtube_link'			=> '',
	

		
		// breadcrumb
		'breadcrumb_category'			=> true,
		'breadcrumb_show'				=> true,
		'breadcrumb_separator'			=> '>',
		'breadcrumb_image'				=> get_template_directory_uri(). '/images/breadcrumb.jpg',
		'breadcrumb_product_image'		=> false,
		
		// layout 
		'site_layout'         			=> 'fluid',
		'sidebar_position' 				=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'no-sidebar',
		'woo_sidebar_position'			=> 'left-sidebar',


		// excerpt options
		'long_excerpt_length'           => 20,
		'read_more_text'           		=> esc_html__( 'Read More', 'ecommerce-plus' ),
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'footer_bg_color'           	=> '#fbfbfb',
		'copyright_text'           		=> esc_html__('eCommerce Plus Theme', 'ecommerce-plus'),
		'scroll_top_visible'        	=> true,
		'footer_image'        			=> '',	
		'footer_text_color'           	=> '#373737',
		
		'popup_cart_visible'        	=> true,	


		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'ecommerce-plus' ),
		'hide_date' 					=> false,
		'hide_category'					=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Landing Page Settings */
		
		'featured_category_0'			=> '',
		'featured_category_1'			=> '',
		'featured_category_2'			=> '',
		'featured_category_3'			=> '',
		'featured_category_4'			=> '',
		'featured_category_5'			=> '',
		'featured_category_6'			=> '',
		'featured_category_7'			=> '',
		'featured_category_8'			=> '',
		'featured_category_9'			=> '',
		
		'featured_category_colums'		=> 'col-md-3 col-sm-3 col-lg-3 col-xs-6',
		'featured_category_height'		=> 150,		
		
		// top bar
		'topbar_login_register_enable'	=> true,
		'topbar_login_label'			=> esc_html__( 'My Account', 'ecommerce-plus' ),
		'topbar_login_url'				=> '',
		
	);

	$output = apply_filters( 'ecommerce_plus_default_theme_options', $ecommerce_plus_default_options );

	return $output;
}