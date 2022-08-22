<?php

add_filter('ecommerce_plus_default_theme_options', 'shop_online_default_settings');

function shop_online_default_settings($ecommerce_plus_default_options){
		
		
	$ecommerce_plus_default_options['primary_color'] = '#d60202';
	$ecommerce_plus_default_options['accent_color'] = '#f7900c';
	$ecommerce_plus_default_options['link_color'] = '#1e73be';
	
	$ecommerce_plus_default_options['site_header_layout'] = 'storefront';
	
	$ecommerce_plus_default_options['header_title_color'] = '#001166';
	
	$ecommerce_plus_default_options['store_menu_color'] = '#555';
	$ecommerce_plus_default_options['store_menubar_color'] = '#0000';
	
	$ecommerce_plus_default_options['menubar_border_height'] = 0;

	$ecommerce_plus_default_options['heading_font'] = 'Google Sans';	
	$ecommerce_plus_default_options['body_font'] = 'Muli';	
	
	
	$ecommerce_plus_default_options['before_shop'] = 0;
	$ecommerce_plus_default_options['after_shop'] = 0;
	
	$ecommerce_plus_default_options['footer_bg_color'] = '#f2f2f270';
	$ecommerce_plus_default_options['footer_text_color'] = '#222121';
	
	$ecommerce_plus_default_options['topbar_login_label'] = esc_html__('Contact', 'shop-online');
	
	$ecommerce_plus_default_options['breadcrumb_image'] = get_stylesheet_directory_uri().'/images/breadcrumb.jpg';
	$ecommerce_plus_default_options['breadcrumb_show'] = true;
	
	$ecommerce_plus_default_options['topbar_login_register_enable'] = false;

	
	return $ecommerce_plus_default_options;
}
