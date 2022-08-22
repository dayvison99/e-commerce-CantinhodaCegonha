<?php
function shopmax_css() {
	$parent_style = 'storebiz-parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'shopmax-style', get_stylesheet_uri(), array( $parent_style ));
	
	wp_enqueue_style('shopmax-media-query',get_stylesheet_directory_uri().'/assets/css/responsive.css');
	wp_dequeue_style('storebiz-media-query');
	wp_enqueue_script('shopmax-custom-js',get_stylesheet_directory_uri().'/assets/js/custom.js', array('jquery'), false, true);
}
add_action( 'wp_enqueue_scripts', 'shopmax_css',999);
   	

/**
 * Import Options From Parent Theme
 *
 */
function shopmax_parent_theme_options() {
	$storebiz_mods = get_option( 'theme_mods_storebiz' );
	if ( ! empty( $storebiz_mods ) ) {
		foreach ( $storebiz_mods as $storebiz_mod_k => $storebiz_mod_v ) {
			set_theme_mod( $storebiz_mod_k, $storebiz_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'shopmax_parent_theme_options' );


require( get_stylesheet_directory() . '/inc/customizer/customizer-pro/class-customize.php');